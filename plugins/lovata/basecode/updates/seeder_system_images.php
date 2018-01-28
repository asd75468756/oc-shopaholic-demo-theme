<?php namespace Lovata\BaseCode\Updates;

use DB;
use Seeder;
use System\Models\File;

/**
 * Class SeederSystemImages
 * @package Lovata\BaseCode\Updates
 */
class SeederSystemImages extends Seeder
{
    public function run()
    {
        //Get all files
        $obFileList = File::all();
        if($obFileList->isEmpty()) {
            return;
        }

        /** @var File $obFile */
        foreach ($obFileList as $obFile) {
            $obFile->delete();
        }

        DB::table('system_files')->truncate();
    }
}