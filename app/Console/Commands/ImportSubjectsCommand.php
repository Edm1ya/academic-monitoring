<?php

namespace App\Console\Commands;

use App\Models\Subject;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportSubjectsCommand extends Command
{
    protected $signature = 'import:subjects {file? : Nombre del archivo CSV}';
    protected $description = 'Importa subjects desde un archivo CSV';

    public function __invoke()
    {
        $fileName = $this->argument('file') ?? 'subjects.csv';

        // Primero busca en storage/app/csv
        if (Storage::exists("csv/{$fileName}")) {
            $filePath = Storage::path("csv/{$fileName}");
        }
        // Luego busca en database/data
        elseif (file_exists(database_path("data/{$fileName}"))) {
            $filePath = database_path("data/{$fileName}");
        }
        else {
            $this->error("No se encontró el archivo CSV!");
            return 1;
        }

        // Abre el archivo CSV
        $handle = fopen($filePath, 'r');

        stream_filter_append($handle, 'convert.iconv.ISO-8859-1/UTF-8');

        // Lee la primera línea como encabezados
        $headers = fgetcsv($handle);


        // Mapeo de encabezados del CSV a nombres de columnas en la base de datos
        $columnMap = [
            'Clave' => 'code',
            'Asignatura' => 'name',
            'HT' => 'theoretical_hours',
            'HP' => 'practical_hours',
            'CR' => 'credits',
            'Prerequisitos' => 'prerequisites',
            'Semestre' => 'semester'
        ];

        // Contador para filas procesadas
        $count = 0;
        $errors = 0;

        // Barra de progreso
        $this->output->progressStart();

        // Procesa cada línea
        while (($data = fgetcsv($handle)) !== false) {
            $row = array_combine($headers, $data);

            try {
                // Mapea los datos del CSV a los nombres de columnas de la base de datos
                $subjectData = [
                    'code' => $row['Clave'],
                    'name' => $row['Asignatura'],
                    'theoretical_hours' => (int)$row['HT'],
                    'practical_hours' => (int)$row['HP'],
                    'credits' => (int)$row['CR'],
                    'prerequisites' => $row['Prerequisitos'] ?: null,
                    'semester' => (int)$row['Semestre']
                ];

                Subject::create($subjectData);

                $count++;
                $this->output->progressAdvance();
            } catch (\Exception $e) {
                $errors++;
                $this->error("Error en la línea {$count} ({$row['Clave']}): " . $e->getMessage());
            }
        }

        fclose($handle);

        $this->output->progressFinish();
        $this->info("Importación completada:");
        $this->info("- Asignaturas importadas: {$count}");
        if ($errors > 0) {
            $this->warn("- Errores encontrados: {$errors}");
        }

        return 0;
    }
}
