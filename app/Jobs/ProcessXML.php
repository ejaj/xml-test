<?php

namespace App\Jobs;

use App\Models\Books;
use App\Helpers\ParseXml;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessXML implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $obj;

    /**
     * Create a new job instance.
     *
     * @return void
     * @param $obj
     */
    public function __construct($obj)
    {
        //
        $this->obj = $obj;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $xml_file = json_decode($this->obj);

        try {
            $obj = $xml_file->books;
            foreach ($obj->book as $data) {
                echo $data->{'@attributes'}->title;
                $image = Books::bookImage($data->image);
                $book_info['title'] = $data->{'@attributes'}->title;
                $book_info['image'] = $image;
                $book_info['isbn'] = $data->{'@attributes'}->isbn;
                $book_info['description'] = $data->description;
                Books::updateOrCreate(
                    [
                        'isbn' => $book_info['isbn'],
                    ],
                    $book_info
                );
            }


        } catch (\Exception $e) {
            $message = "Message : " . $e->getMessage() . ", File : " . $e->getFile() . ", Line : " . $e->getLine();
            Log::debug($message);
        }
    }
}
