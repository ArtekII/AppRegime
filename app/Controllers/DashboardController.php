<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseConnection;

class DashboardController extends BaseController
{
    private BaseConnection $db;

    public function index(): string
    {
        $this->db = db_connect();

        $objectifDistribution = $this->getObjectifDistribution();
        $inscriptions = $this->getInscriptions();

        return view('dashboard', [
            'stats' => [
                'totalUsers' => $this->countTable('utilisateur'),
                'goldSubscribers' => $this->countTable('abonnements_gold'),
                'totalRevenue' => $this->getTotalRevenue(),
                'totalRegimes' => $this->countTable('regime'),
                'totalActivites' => $this->countTable('activite_sportive'),
                'usedCodes' => $this->getUsedCodesCount(),
                'activeObjectifs' => $this->getActiveObjectifsCount(),
            ],
            'objectifDistribution' => $objectifDistribution,
            'pieGradient' => $this->buildPieGradient($objectifDistribution),
            'inscriptions' => $inscriptions,
            'lineChart' => $this->buildLineChart($inscriptions),
            'objectifGenreRows' => $this->getObjectifGenreRows(),
        ]);
    }

    private function countTable(string $table): int
    {
        if (! $this->db->tableExists($table)) {
            return 0;
        }

        return (int) $this->db->table($table)->countAllResults();
    }

    private function sumColumn(string $table, string $column): float
    {
        if (! $this->db->tableExists($table)) {
            return 0.0;
        }

        $row = $this->db->table($table)
            ->selectSum($column, 'total')
            ->get()
            ->getRowArray();

        return (float) ($row['total'] ?? 0);
    }

    private function getTotalRevenue(): float
    {
        return $this->sumColumn('achat_regime', 'montant')
            + $this->sumColumn('abonnements_gold', 'prix');
    }

    private function getUsedCodesCount(): int
    {
        if ($this->db->tableExists('code_historique')) {
            return (int) $this->db->table('code_historique')
                ->where('utilise', 1)
                ->countAllResults();
        }

        if ($this->db->tableExists('code_montant')) {
            return (int) $this->db->table('code_montant')
                ->where('utilise', 1)
                ->countAllResults();
        }

        return 0;
    }

    private function getActiveObjectifsCount(): int
    {
        if (! $this->db->tableExists('utilisateur_objectif')) {
            return 0;
        }

        if (! $this->db->tableExists('statut')) {
            return (int) $this->db->table('utilisateur_objectif')->countAllResults();
        }

        return (int) $this->db->table('utilisateur_objectif')
            ->join('statut', 'statut.id = utilisateur_objectif.statut_id')
            ->where('statut.nom', 'En cours')
            ->countAllResults();
    }

    private function getObjectifDistribution(): array
    {
        $base = [
            'reduire' => ['label' => 'Reduire poids', 'count' => 0, 'percent' => 0, 'class' => 'reduce'],
            'imc' => ['label' => 'IMC ideal', 'count' => 0, 'percent' => 0, 'class' => 'imc'],
            'augmenter' => ['label' => 'Augmenter poids', 'count' => 0, 'percent' => 0, 'class' => 'gain'],
        ];

        if (! $this->db->tableExists('utilisateur_objectif') || ! $this->db->tableExists('objectif')) {
            return $base;
        }

        $rows = $this->db->table('utilisateur_objectif')
            ->select('objectif.type, COUNT(*) as total')
            ->join('objectif', 'objectif.id = utilisateur_objectif.objectif_id')
            ->groupBy('objectif.id, objectif.type')
            ->get()
            ->getResultArray();

        $total = 0;
        foreach ($rows as $row) {
            $key = $this->objectifKey((string) $row['type']);
            if ($key === null) {
                continue;
            }

            $base[$key]['count'] = (int) $row['total'];
            $total += (int) $row['total'];
        }

        if ($total > 0) {
            foreach ($base as $key => $item) {
                $base[$key]['percent'] = round($item['count'] * 100 / $total, 1);
            }
        }

        return $base;
    }

    private function getInscriptions(): array
    {
        if (! $this->db->tableExists('utilisateur')) {
            return [];
        }

        $rows = $this->db->query(
            "SELECT DATE(date_creation) AS date_inscription, COUNT(*) AS total
             FROM utilisateur
             GROUP BY DATE(date_creation)
             ORDER BY date_inscription DESC
             LIMIT 7"
        )->getResultArray();

        $rows = array_reverse($rows);

        return array_map(static function (array $row): array {
            $timestamp = strtotime((string) $row['date_inscription']);

            return [
                'label' => $timestamp !== false ? date('d/m', $timestamp) : (string) $row['date_inscription'],
                'count' => (int) $row['total'],
            ];
        }, $rows);
    }

    private function getObjectifGenreRows(): array
    {
        $rowsByObjective = [
            'reduire' => ['label' => 'Reduire poids', 'Homme' => 0, 'Femme' => 0, 'Autre' => 0, 'total' => 0],
            'imc' => ['label' => 'IMC ideal', 'Homme' => 0, 'Femme' => 0, 'Autre' => 0, 'total' => 0],
            'augmenter' => ['label' => 'Augmenter poids', 'Homme' => 0, 'Femme' => 0, 'Autre' => 0, 'total' => 0],
        ];

        if (
            ! $this->db->tableExists('utilisateur_objectif')
            || ! $this->db->tableExists('utilisateur')
            || ! $this->db->tableExists('objectif')
        ) {
            return array_values($rowsByObjective);
        }

        $rows = $this->db->table('utilisateur_objectif')
            ->select('objectif.type, utilisateur.genre, COUNT(*) as total')
            ->join('objectif', 'objectif.id = utilisateur_objectif.objectif_id')
            ->join('utilisateur', 'utilisateur.id = utilisateur_objectif.utilisateur_id')
            ->groupBy('objectif.id, objectif.type, utilisateur.genre')
            ->get()
            ->getResultArray();

        foreach ($rows as $row) {
            $key = $this->objectifKey((string) $row['type']);
            $genre = (string) $row['genre'];

            if ($key === null || ! array_key_exists($genre, $rowsByObjective[$key])) {
                continue;
            }

            $count = (int) $row['total'];
            $rowsByObjective[$key][$genre] = $count;
            $rowsByObjective[$key]['total'] += $count;
        }

        return array_values($rowsByObjective);
    }

    private function buildPieGradient(array $distribution): string
    {
        $colors = [
            'reduire' => '#2563eb',
            'imc' => '#16a34a',
            'augmenter' => '#f59e0b',
        ];

        $segments = [];
        $start = 0.0;

        foreach ($distribution as $key => $item) {
            $end = $start + (float) $item['percent'];
            if ($end > $start) {
                $segments[] = $colors[$key] . ' ' . $start . '% ' . $end . '%';
            }
            $start = $end;
        }

        if ($segments === []) {
            return 'conic-gradient(#e5e7eb 0 100%)';
        }

        return 'conic-gradient(' . implode(', ', $segments) . ')';
    }

    private function buildLineChart(array $points): array
    {
        $width = 420;
        $height = 220;
        $left = 40;
        $right = 390;
        $top = 28;
        $bottom = 180;
        $count = count($points);
        $maxValue = max(1, ...array_column($points, 'count'));
        $chartPoints = [];

        foreach ($points as $index => $point) {
            $x = $count <= 1 ? $left : $left + (($right - $left) * $index / ($count - 1));
            $y = $bottom - (($bottom - $top) * $point['count'] / $maxValue);
            $chartPoints[] = [
                'x' => round($x, 1),
                'y' => round($y, 1),
                'label' => $point['label'],
                'count' => $point['count'],
            ];
        }

        return [
            'width' => $width,
            'height' => $height,
            'left' => $left,
            'right' => $right,
            'top' => $top,
            'bottom' => $bottom,
            'points' => $chartPoints,
            'polyline' => implode(' ', array_map(
                static fn (array $point): string => $point['x'] . ',' . $point['y'],
                $chartPoints
            )),
        ];
    }

    private function objectifKey(string $type): ?string
    {
        $type = strtolower($type);

        if (str_contains($type, 'redu') || str_contains($type, 'duire')) {
            return 'reduire';
        }

        if (str_contains($type, 'imc')) {
            return 'imc';
        }

        if (str_contains($type, 'augmenter')) {
            return 'augmenter';
        }

        return null;
    }
}
