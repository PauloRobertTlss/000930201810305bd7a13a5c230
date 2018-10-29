<?php


namespace ChatPool\Observers;

use Leroy\Entities\Document;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DocumentObserver
{
    public function created(Document $document)
    {
        //consolidado
    }
    public function creating(Document $document)
    {
        //pre-processamento
    }
    
    public function deleting(Document $document)
    {
    
    }

    public function updating(Document $document)
    {
        /**
         * file_path : neste momento é o arquivo (iria dar error pois o banco está esperando uma string)
         */
        if (is_a($message->file_path, UploadedFile::class) and $message->file_path->isValid()) {
            $previous_image = $message->getOriginal('file_path');
                    \Log::info("fila de trabaho [Create Image Thumbnail and Upload] [$message->custom_uid]");
                            $message->file_mime_type = $message->file_path->getClientMimeType();
                            $message->file_size = $message->file_path->getClientSize();
                        $extension = $message->file_path->extension();
                        $file_name_temp = bin2hex(openssl_random_pseudo_bytes(8)).'.'.$extension;
                        $message->file_path->move(sys_get_temp_dir(),$file_name_temp); //Job não serializa Uploads [salvar localmente]
                $job = (new CreateImageThumbnailAndUploadForS3($message,$file_name_temp,$extension))->delay(Carbon::now()->addSeconds(2));
                dispatch($job);
                //$this->upload($message);
            if ($previous_image !== null){ Storage::delete('EAADK4YfOZCiUBAD0tMOq3GcXrTTO/' . $previous_image);}
        }
    }

}