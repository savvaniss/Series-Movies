<?php

namespace App\Services;

//we will try to implement and services for all interaction with data
//the idea is that if hash file exist then someone else upload exact the same file
//so we don't need to add it on files. And only to make a record to the database for
//existing file.

//Also for deletion will first check if onother Actor or Series has entry in database
//only if it is the last entry then we delete file also. elseware we delete only the entry
class DataApi{
    protected $datadir='datahouse';
    
    
    //check if datadir exist if not create it
    public function __construct (){
    }
    //calculate hash for given file
            
    public function calculateHash($file){
        return md5($file);
    }
    
    //check if the same file exist
    //if file hash same hash mean it is the same file. no reason to reupload
    //only add entry in database
    public function hashExistInData($hash){
        if(file_exists(__DIR__ . '/../'.$datadir.'/'.$hash)){
            return true;
        }
        return false;
    } 
    //check if more than 1 record for this file exist in db.
    // if yes return true. if one record or less exist return false
    public function hashHasMamyRecords(){
    
    }
    
   
}