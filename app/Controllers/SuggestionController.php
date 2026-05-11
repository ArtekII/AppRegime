<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AbonnementGoldModel;
use App\Models\ActiviteObjectifModel;
use App\Models\ObjectifModel;
use App\Models\RegimeObjectifModel;
use App\Models\UtilisateurObjectifModel;
use App\Models\UserModel;

class SuggestionController extends BaseController
{
    private const GOLD_DISCOUNT_RATE = 0.15;

    public function index()
    {
        $objectifsModel = new ObjectifModel();
        $objectifs = $objectifsModel->findAll();
        $objectifId = (int) $this->request->getGet('objectif_id');
        $utilisateurId = (int) ($this->request->getGet('utilisateur_id') ?? session()->get('user_id'));
        $regimes = [];
        $activites = [];
        $utilisateur = null;
        $utilisateurObjectif = null;
        $imc = null;
        $categorieImc = null;
        $imcCible = null;
        $poidsCible = null;
        $imcIdealAtteint = null;
        $ecartImcCible = null;

        if ($utilisateurId > 0) {
            $userModel = new UserModel();
            $utilisateur = $userModel->find($utilisateurId);
            $utilisateurObjectifModel = new UtilisateurObjectifModel();
            $utilisateurObjectif = $utilisateurObjectifModel
                ->where('utilisateur_id', $utilisateurId)
                ->where('objectif_id', $objectifId)
                ->orderBy('id', 'DESC')
                ->first();

            if ($utilisateur !== null) {
                $tailleMetres = (float) $utilisateur['taille'] / 100;
                $poids = (float) $utilisateur['poids'];

                if ($tailleMetres > 0 && $poids > 0) {
                    $imc = round($poids / ($tailleMetres * $tailleMetres), 1);
                    $categorieImc = $this->getCategorieImc($imc);
                }

                if ($tailleMetres > 0 && ! empty($utilisateurObjectif['imc_cible'])) {
                    $imcCible = (float) $utilisateurObjectif['imc_cible'];
                    $poidsCible = round($imcCible * ($tailleMetres * $tailleMetres), 1);

                    if ($imc !== null) {
                        $ecartImcCible = round(abs($imc - $imcCible), 1);
                        $imcIdealAtteint = $ecartImcCible === 0.0;
                    }
                }
            }
        }

        if ($objectifId > 0) {
            $regimeObjectifModel = new RegimeObjectifModel();
            $activiteObjectifModel = new ActiviteObjectifModel();

            $regimes = $regimeObjectifModel->getRegimesByObjectifId($objectifId);
            $activites = $activiteObjectifModel->getActivitesByObjectifId($objectifId);
        }

        return view('suggestions/suggestions', [
            'objectifs' => $objectifs,
            'objectifId' => $objectifId,
            'utilisateurId' => $utilisateurId > 0 ? $utilisateurId : null,
            'utilisateur' => $utilisateur,
            'utilisateurObjectif' => $utilisateurObjectif,
            'imc' => $imc,
            'categorieImc' => $categorieImc,
            'imcCible' => $imcCible,
            'poidsCible' => $poidsCible,
            'imcIdealAtteint' => $imcIdealAtteint,
            'ecartImcCible' => $ecartImcCible,
            'regimes' => $regimes,
            'activites' => $activites,
            'isGold' => $this->userHasGold($utilisateurId),
            'goldDiscountRate' => self::GOLD_DISCOUNT_RATE,
        ]);
    }

    public function exportPdf()
    {
        require_once APPPATH . 'Libraries/fpdf/fpdf.php';

        $userId = (int) session()->get('user_id');
        $objectifId = (int) $this->request->getGet('objectif_id');

        $userModel = new UserModel();
        $objectifModel = new ObjectifModel();
        $utilisateurObjectifModel = new UtilisateurObjectifModel();
        $regimeObjectifModel = new RegimeObjectifModel();
        $activiteObjectifModel = new ActiviteObjectifModel();

        $utilisateur = $userModel->find($userId);
        if ($utilisateur === null) {
            return redirect()->to(site_url('connexion'))->with('error', 'Veuillez vous connecter.');
        }

        if ($objectifId <= 0) {
            $lastObjectif = $utilisateurObjectifModel
                ->where('utilisateur_id', $userId)
                ->orderBy('id', 'DESC')
                ->first();
            $objectifId = (int) ($lastObjectif['objectif_id'] ?? 0);
        }

        $objectif = $objectifModel->find($objectifId);
        if ($objectif === null) {
            return redirect()->to(site_url('suggestions'))->with('error', 'Objectif introuvable.');
        }

        $utilisateurObjectif = $utilisateurObjectifModel
            ->where('utilisateur_id', $userId)
            ->where('objectif_id', $objectifId)
            ->orderBy('id', 'DESC')
            ->first();

        $profil = $this->buildProfilData($utilisateur, $utilisateurObjectif);
        $regimes = $regimeObjectifModel->getRegimesByObjectifId($objectifId);
        $activites = $activiteObjectifModel->getActivitesByObjectifId($objectifId);
        $isGold = $this->userHasGold($userId);

        $pdf = new \FPDF();
        $pdf->SetAutoPageBreak(true, 15);
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, $this->pdfText('Suggestions personnalisees'), 0, 1);
        $pdf->Ln(3);

        $this->writePdfSectionTitle($pdf, 'Profil utilisateur');
        $this->writePdfLine($pdf, 'Nom: ' . $utilisateur['nom']);
        $this->writePdfLine($pdf, 'Email: ' . $utilisateur['email']);
        $this->writePdfLine($pdf, 'Genre: ' . $utilisateur['genre']);
        $this->writePdfLine($pdf, 'Taille: ' . $utilisateur['taille'] . ' cm');
        $this->writePdfLine($pdf, 'Poids: ' . $utilisateur['poids'] . ' kg');
        $this->writePdfLine($pdf, 'Solde: ' . number_format((float) $utilisateur['solde'], 2, ',', ' ') . ' Ar');

        if ($profil['imc'] !== null) {
            $this->writePdfLine($pdf, 'IMC: ' . $profil['imc'] . ' (' . $profil['categorieImc'] . ')');
        }

        $this->writePdfSectionTitle($pdf, 'Objectif');
        $this->writePdfLine($pdf, 'Objectif choisi: ' . $objectif['type']);
        if ($profil['imcCible'] !== null && $profil['poidsCible'] !== null) {
            $this->writePdfLine($pdf, 'IMC cible: ' . $profil['imcCible']);
            $this->writePdfLine($pdf, 'Poids cible estime: ' . $profil['poidsCible'] . ' kg');
        }

        $this->writePdfSectionTitle($pdf, 'Suggestions de regimes');
        if ($regimes === []) {
            $this->writePdfLine($pdf, 'Aucun regime disponible pour cet objectif.');
        }

        foreach ($regimes as $regime) {
            $this->writePdfLine($pdf, '- ' . $regime['regime_nom'], true);
            $this->writePdfLine($pdf, '  Composition: viandes ' . $regime['pourcentage_viandes'] . '%, poissons ' . $regime['pourcentage_poissons'] . '%, volailles ' . $regime['pourcentage_volailles'] . '%.');
            $this->writePdfLine($pdf, '  Poids cible: ' . $regime['poids_min'] . ' kg a ' . $regime['poids_max'] . ' kg.');
            $this->writePdfLine($pdf, '  Duree: ' . $regime['duree_jours'] . ' jours.');
            if (! empty($regime['prix'])) {
                $prixInitial = (float) $regime['prix'];
                $prixFinal = $this->applyGoldDiscount($prixInitial, $isGold);
                $prixText = number_format($prixFinal, 2, ',', ' ') . ' Ar';
                if ($isGold) {
                    $prixText .= ' (remise Gold 15%, prix initial: ' . number_format($prixInitial, 2, ',', ' ') . ' Ar)';
                }
            } else {
                $prixText = 'non disponible';
            }

            $this->writePdfLine($pdf, '  Prix: ' . $prixText . '.');
            $pdf->Ln(1);
        }

        $this->writePdfSectionTitle($pdf, 'Suggestions d activites');
        if ($activites === []) {
            $this->writePdfLine($pdf, 'Aucune activite disponible pour cet objectif.');
        }

        foreach ($activites as $activite) {
            $this->writePdfLine($pdf, '- ' . $activite['activite_nom'], true);
            $this->writePdfLine($pdf, '  Frequence: ' . $activite['frequence_par_semaine'] . ' fois par semaine.');
            $this->writePdfLine($pdf, '  Duree par seance: ' . $activite['duree_minutes_par_seance'] . ' minutes.');
            $this->writePdfLine($pdf, '  Programme: ' . $activite['duree_jours'] . ' jours.');
            $this->writePdfLine($pdf, '  Calories par heure: ' . $activite['calories_brulees_par_heure'] . ' kcal.');
            $this->writePdfLine($pdf, '  Calories par seance: ' . round((float) $activite['calories_par_seance'], 1) . ' kcal.');
            $this->writePdfLine($pdf, '  Calories par semaine: ' . round((float) $activite['calories_par_semaine'], 1) . ' kcal.');
            $pdf->Ln(1);
        }

        $fileName = 'suggestions-' . date('Ymd-His') . '.pdf';

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->setBody($pdf->Output('S'));
    }

    private function buildProfilData(array $utilisateur, ?array $utilisateurObjectif): array
    {
        $imc = null;
        $categorieImc = null;
        $imcCible = null;
        $poidsCible = null;
        $tailleMetres = (float) $utilisateur['taille'] / 100;
        $poids = (float) $utilisateur['poids'];

        if ($tailleMetres > 0 && $poids > 0) {
            $imc = round($poids / ($tailleMetres * $tailleMetres), 1);
            $categorieImc = $this->getCategorieImc($imc);
        }

        if ($tailleMetres > 0 && ! empty($utilisateurObjectif['imc_cible'])) {
            $imcCible = (float) $utilisateurObjectif['imc_cible'];
            $poidsCible = round($imcCible * ($tailleMetres * $tailleMetres), 1);
        }

        return [
            'imc' => $imc,
            'categorieImc' => $categorieImc,
            'imcCible' => $imcCible,
            'poidsCible' => $poidsCible,
        ];
    }

    private function writePdfSectionTitle(\FPDF $pdf, string $title): void
    {
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Cell(0, 8, $this->pdfText($title), 0, 1);
        $pdf->SetFont('Arial', '', 11);
    }

    private function writePdfLine(\FPDF $pdf, string $text, bool $bold = false): void
    {
        $pdf->SetFont('Arial', $bold ? 'B' : '', 11);
        $pdf->MultiCell(0, 6, $this->pdfText($text));
    }

    private function pdfText(string $text): string
    {
        $converted = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $text);

        return $converted !== false ? $converted : $text;
    }

    private function userHasGold(int $userId): bool
    {
        if ($userId <= 0) {
            return false;
        }

        return (new AbonnementGoldModel())
            ->where('utilisateur_id', $userId)
            ->first() !== null;
    }

    private function applyGoldDiscount(float $price, bool $isGold): float
    {
        if (! $isGold) {
            return $price;
        }

        return round($price * (1 - self::GOLD_DISCOUNT_RATE), 2);
    }

    private function getCategorieImc(float $imc): string
    {
        if ($imc < 18.5) {
            return 'Insuffisance ponderale';
        }

        if ($imc < 25) {
            return 'Corpulence normale';
        }

        if ($imc < 30) {
            return 'Surpoids';
        }

        return 'Obesite';
    }
}
