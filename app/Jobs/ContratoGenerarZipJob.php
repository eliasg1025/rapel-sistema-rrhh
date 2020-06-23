<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use iio\libmergepdf\Merger;
use Illuminate\Support\Facades\File;

class ContratoGenerarZipJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private $fecha_actual;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $fecha_actual)
    {
        $this->fecha_actual = $fecha_actual;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $files = \Storage::disk('public')->files($this->fecha_actual);
        $path = storage_path() . '/app/public';

        $f = [];
        foreach ($files as $file) {
            array_push($f, $path . '/' . $file);
        }

        $merger = new Merger();

        foreach ($f as $file) {
            $merger->addFile($file);
        }
        $createdPdf = $merger->merge();
        $filename = 'carga-pdf/' . $this->fecha_actual . '.pdf';

        \Storage::disk('public')->put($filename, $createdPdf);
    }
}
