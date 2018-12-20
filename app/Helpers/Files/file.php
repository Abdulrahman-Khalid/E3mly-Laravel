<?php 
namespace App\Helpers\Files;

class file {
    public static function upload($fileToUpload) {
        if($request->hasFile('description_file'))
        {
            $fileNameWithExt = $fileToUpload->getClientOriginalName();
            //get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get just ext
            $extension = $fileToUpload->guessClientExtension();
            if($extension == 'pdf')
            {
                $fileNameToStore = $fileName.'_'.time().'.'.$extension;
                //upload file
                $path = $fileToUpload->storeAs('public/ProjectDescriptions', $fileNameToStore);
            }
            else
            {
                $fileNameToStore = 'nofile.pdf';
            }
        }
        else    
        {
            $fileNameToStore = 'nofile.pdf';
        }
        return $fileNameToStore;
    }
}