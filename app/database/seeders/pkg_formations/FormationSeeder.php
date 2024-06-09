<?php

namespace Database\Seeders\pkg_formations;

use App\Models\pkg_formations\Formation;
use App\Models\pkg_formations\Formateur; // Import du modèle Formateur
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class FormationSeeder extends Seeder

    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            Schema::disableForeignKeyConstraints();
            Formation::truncate();
            Schema::enableForeignKeyConstraints();
        
            $csvFile = fopen(base_path("database/data/pkg_formations/formations.csv"), "r");
            $firstline = true;
        
            while (($data = fgetcsv($csvFile)) !== FALSE) {
                if (!$firstline) {
                    // Vérifiez que la ligne a bien trois colonnes
                    if (count($data) == 3) {
                        Formation::create([
                            'nom' => $data[0],
                            'description' => $data[1],
                            'lien' => $data[2]
                        ]);
                    } else {
                        // Gérer le cas où la ligne n'a pas le bon nombre de colonnes
                        // Par exemple, en affichant un message d'erreur ou en journalisant l'incident.
                        // Vous pouvez également décider de sauter la ligne ou d'arrêter le processus de semis.
                        // Dans cet exemple, je vais simplement afficher un message d'erreur.
                        echo "Erreur: La ligne du fichier CSV n'a pas le bon nombre de colonnes.\n";
                    }
                }
                $firstline = false;
            }
        
            fclose($csvFile);
        }
        
    }

