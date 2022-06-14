<?php

namespace App\Models\Images;

use App\Traits\CanUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory, CanUpload;

    protected $fillable = [
        'name',
        'filename',
        'extension',
        'folder',
        'mime',
        'size',
    ];

    public function getURL() {
        return asset( $this->folder . $this->filename );
    }

    public function getSize( $bHuman = true, $sUnit = 'MB' ) {
        if( $bHuman ) {
            switch( $sUnit ) {
                case 'GB':
                    return round( $this->size / 1024 / 1024 / 1024, 2 ) . ' GB';
                case 'MB':
                    return round( $this->size / 1024 / 1024, 2 ) . ' MB';
                case 'B':
                    return $this->size . ' B';
                case 'KB':
                default:
                    return round( $this->size / 1024, 2 ) . ' KB';
            }
        } else {
            return $this->size;
        }

    }

}
