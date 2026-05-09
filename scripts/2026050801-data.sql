USE app_regime_db;

INSERT INTO utilisateur (nom, email, mot_de_passe, genre, taille, poids, role, solde)
SELECT 'Alice Martin', 'alice.martin@test.local', 'password', 'Femme', 165, 62.5, 'utilisateur', 25.00
WHERE NOT EXISTS (SELECT 1 FROM utilisateur WHERE email = 'alice.martin@test.local');

INSERT INTO utilisateur (nom, email, mot_de_passe, genre, taille, poids, role, solde)
SELECT 'Bruno Bernard', 'bruno.bernard@test.local', 'password', 'Homme', 178, 82.0, 'utilisateur', 10.00
WHERE NOT EXISTS (SELECT 1 FROM utilisateur WHERE email = 'bruno.bernard@test.local');

INSERT INTO utilisateur (nom, email, mot_de_passe, genre, taille, poids, role, solde)
SELECT 'Camille Durand', 'camille.durand@test.local', 'password', 'Autre', 170, 68.0, 'utilisateur', 0.00
WHERE NOT EXISTS (SELECT 1 FROM utilisateur WHERE email = 'camille.durand@test.local');

INSERT INTO utilisateur (nom, email, mot_de_passe, genre, taille, poids, role, solde)
SELECT 'Diane Leroy', 'diane.leroy@test.local', 'password', 'Femme', 160, 54.0, 'utilisateur', 50.00
WHERE NOT EXISTS (SELECT 1 FROM utilisateur WHERE email = 'diane.leroy@test.local');

INSERT INTO utilisateur (nom, email, mot_de_passe, genre, taille, poids, role, solde)
SELECT 'Etienne Moreau', 'etienne.moreau@test.local', 'password', 'Homme', 183, 91.0, 'admin', 100.00
WHERE NOT EXISTS (SELECT 1 FROM utilisateur WHERE email = 'etienne.moreau@test.local');

INSERT INTO regime (nom, pourcentage_viandes, pourcentage_poissons, pourcentage_volailles)
SELECT 'Equilibre starter', 35, 30, 35
WHERE NOT EXISTS (SELECT 1 FROM regime WHERE nom = 'Equilibre starter');

INSERT INTO regime (nom, pourcentage_viandes, pourcentage_poissons, pourcentage_volailles)
SELECT 'Force proteinee', 45, 20, 35
WHERE NOT EXISTS (SELECT 1 FROM regime WHERE nom = 'Force proteinee');

INSERT INTO regime (nom, pourcentage_viandes, pourcentage_poissons, pourcentage_volailles)
SELECT 'Leger poisson', 20, 55, 25
WHERE NOT EXISTS (SELECT 1 FROM regime WHERE nom = 'Leger poisson');

INSERT INTO regime (nom, pourcentage_viandes, pourcentage_poissons, pourcentage_volailles)
SELECT 'Volaille minceur', 20, 25, 55
WHERE NOT EXISTS (SELECT 1 FROM regime WHERE nom = 'Volaille minceur');

INSERT INTO regime (nom, pourcentage_viandes, pourcentage_poissons, pourcentage_volailles)
SELECT 'Mix maintien', 33, 34, 33
WHERE NOT EXISTS (SELECT 1 FROM regime WHERE nom = 'Mix maintien');

INSERT INTO prix_regimes (duree_jours, regime_id, prix)
SELECT 30, r.id, 45000.00
FROM regime r
WHERE r.nom = 'Equilibre starter'
AND NOT EXISTS (SELECT 1 FROM prix_regimes pr WHERE pr.regime_id = r.id AND pr.duree_jours = 30);

INSERT INTO prix_regimes (duree_jours, regime_id, prix)
SELECT 30, r.id, 65000.00
FROM regime r
WHERE r.nom = 'Force proteinee'
AND NOT EXISTS (SELECT 1 FROM prix_regimes pr WHERE pr.regime_id = r.id AND pr.duree_jours = 30);

INSERT INTO prix_regimes (duree_jours, regime_id, prix)
SELECT 30, r.id, 58000.00
FROM regime r
WHERE r.nom = 'Leger poisson'
AND NOT EXISTS (SELECT 1 FROM prix_regimes pr WHERE pr.regime_id = r.id AND pr.duree_jours = 30);

INSERT INTO prix_regimes (duree_jours, regime_id, prix)
SELECT 45, r.id, 72000.00
FROM regime r
WHERE r.nom = 'Volaille minceur'
AND NOT EXISTS (SELECT 1 FROM prix_regimes pr WHERE pr.regime_id = r.id AND pr.duree_jours = 45);

INSERT INTO prix_regimes (duree_jours, regime_id, prix)
SELECT 30, r.id, 52000.00
FROM regime r
WHERE r.nom = 'Mix maintien'
AND NOT EXISTS (SELECT 1 FROM prix_regimes pr WHERE pr.regime_id = r.id AND pr.duree_jours = 30);

INSERT INTO prix_regimes (duree_jours, regime_id, prix)
SELECT 60, r.id, 98000.00
FROM regime r
WHERE r.nom = 'Mix maintien'
AND NOT EXISTS (SELECT 1 FROM prix_regimes pr WHERE pr.regime_id = r.id AND pr.duree_jours = 60);

INSERT INTO activite_sportive (nom, calories_brulees_par_heure)
SELECT 'Marche rapide', 280
WHERE NOT EXISTS (SELECT 1 FROM activite_sportive WHERE nom = 'Marche rapide');

INSERT INTO activite_sportive (nom, calories_brulees_par_heure)
SELECT 'Course a pied', 650
WHERE NOT EXISTS (SELECT 1 FROM activite_sportive WHERE nom = 'Course a pied');

INSERT INTO activite_sportive (nom, calories_brulees_par_heure)
SELECT 'Natation', 500
WHERE NOT EXISTS (SELECT 1 FROM activite_sportive WHERE nom = 'Natation');

INSERT INTO activite_sportive (nom, calories_brulees_par_heure)
SELECT 'Velo', 420
WHERE NOT EXISTS (SELECT 1 FROM activite_sportive WHERE nom = 'Velo');

INSERT INTO activite_sportive (nom, calories_brulees_par_heure)
SELECT 'Musculation', 380
WHERE NOT EXISTS (SELECT 1 FROM activite_sportive WHERE nom = 'Musculation');

INSERT INTO utilisateur_objectif (utilisateur_id, objectif_id, statut_id)
SELECT u.id, o.id, s.id
FROM utilisateur u
CROSS JOIN (SELECT id FROM objectif ORDER BY id LIMIT 1) o
CROSS JOIN (SELECT id FROM statut ORDER BY id LIMIT 1) s
WHERE u.email = 'alice.martin@test.local'
AND NOT EXISTS (SELECT 1 FROM utilisateur_objectif uo WHERE uo.utilisateur_id = u.id);

INSERT INTO utilisateur_objectif (utilisateur_id, objectif_id, statut_id)
SELECT u.id, o.id, s.id
FROM utilisateur u
CROSS JOIN (SELECT id FROM objectif ORDER BY id LIMIT 1 OFFSET 1) o
CROSS JOIN (SELECT id FROM statut ORDER BY id LIMIT 1) s
WHERE u.email = 'bruno.bernard@test.local'
AND NOT EXISTS (SELECT 1 FROM utilisateur_objectif uo WHERE uo.utilisateur_id = u.id);

INSERT INTO utilisateur_objectif (utilisateur_id, objectif_id, statut_id)
SELECT u.id, o.id, s.id
FROM utilisateur u
CROSS JOIN (SELECT id FROM objectif ORDER BY id LIMIT 1 OFFSET 2) o
CROSS JOIN (SELECT id FROM statut ORDER BY id LIMIT 1) s
WHERE u.email = 'camille.durand@test.local'
AND NOT EXISTS (SELECT 1 FROM utilisateur_objectif uo WHERE uo.utilisateur_id = u.id);

UPDATE utilisateur_objectif uo
JOIN utilisateur u ON u.id = uo.utilisateur_id
SET uo.imc_cible = 22.0
WHERE u.email = 'camille.durand@test.local';

INSERT INTO utilisateur_objectif (utilisateur_id, objectif_id, statut_id)
SELECT u.id, o.id, s.id
FROM utilisateur u
CROSS JOIN (SELECT id FROM objectif ORDER BY id LIMIT 1 OFFSET 1) o
CROSS JOIN (SELECT id FROM statut ORDER BY id LIMIT 1) s
WHERE u.email = 'diane.leroy@test.local'
AND NOT EXISTS (SELECT 1 FROM utilisateur_objectif uo WHERE uo.utilisateur_id = u.id);

INSERT INTO utilisateur_objectif (utilisateur_id, objectif_id, statut_id)
SELECT u.id, o.id, s.id
FROM utilisateur u
CROSS JOIN (SELECT id FROM objectif ORDER BY id LIMIT 1) o
CROSS JOIN (SELECT id FROM statut ORDER BY id LIMIT 1) s
WHERE u.email = 'etienne.moreau@test.local'
AND NOT EXISTS (SELECT 1 FROM utilisateur_objectif uo WHERE uo.utilisateur_id = u.id);

INSERT INTO regime_objectif (regime_id, objectif_id, poids_min, poids_max, duree_jours)
SELECT r.id, o.id, 45, 65, 30
FROM regime r
CROSS JOIN (SELECT id FROM objectif ORDER BY id LIMIT 1) o
WHERE r.nom = 'Force proteinee'
AND NOT EXISTS (SELECT 1 FROM regime_objectif ro WHERE ro.regime_id = r.id AND ro.objectif_id = o.id);

INSERT INTO regime_objectif (regime_id, objectif_id, poids_min, poids_max, duree_jours)
SELECT r.id, o.id, 65, 110, 45
FROM regime r
CROSS JOIN (SELECT id FROM objectif ORDER BY id LIMIT 1 OFFSET 1) o
WHERE r.nom = 'Volaille minceur'
AND NOT EXISTS (SELECT 1 FROM regime_objectif ro WHERE ro.regime_id = r.id AND ro.objectif_id = o.id);

INSERT INTO regime_objectif (regime_id, objectif_id, poids_min, poids_max, duree_jours)
SELECT r.id, o.id, 50, 85, 30
FROM regime r
CROSS JOIN (SELECT id FROM objectif ORDER BY id LIMIT 1 OFFSET 2) o
WHERE r.nom = 'Mix maintien'
AND NOT EXISTS (SELECT 1 FROM regime_objectif ro WHERE ro.regime_id = r.id AND ro.objectif_id = o.id);

INSERT INTO activite_objectif (activite_id, objectif_id, duree_jours, frequence_par_semaine, duree_minutes_par_seance)
SELECT a.id, o.id, 30, 3, 45
FROM activite_sportive a
CROSS JOIN (SELECT id FROM objectif ORDER BY id LIMIT 1) o
WHERE a.nom = 'Musculation'
AND NOT EXISTS (SELECT 1 FROM activite_objectif ao WHERE ao.activite_id = a.id AND ao.objectif_id = o.id);

INSERT INTO activite_objectif (activite_id, objectif_id, duree_jours, frequence_par_semaine, duree_minutes_par_seance)
SELECT a.id, o.id, 45, 4, 35
FROM activite_sportive a
CROSS JOIN (SELECT id FROM objectif ORDER BY id LIMIT 1 OFFSET 1) o
WHERE a.nom = 'Course a pied'
AND NOT EXISTS (SELECT 1 FROM activite_objectif ao WHERE ao.activite_id = a.id AND ao.objectif_id = o.id);

INSERT INTO activite_objectif (activite_id, objectif_id, duree_jours, frequence_par_semaine, duree_minutes_par_seance)
SELECT a.id, o.id, 30, 3, 40
FROM activite_sportive a
CROSS JOIN (SELECT id FROM objectif ORDER BY id LIMIT 1 OFFSET 2) o
WHERE a.nom = 'Natation'
AND NOT EXISTS (SELECT 1 FROM activite_objectif ao WHERE ao.activite_id = a.id AND ao.objectif_id = o.id);
