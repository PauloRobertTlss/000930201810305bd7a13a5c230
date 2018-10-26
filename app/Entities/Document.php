<?php

namespace Leroy\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Document.
 *
 * @package namespace Leroy\Entities;
 */
class Document extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','name','path','file_display','hash_endpoing','processed','progress'];
    
    public function getProgress(){
        
        switch ($this->progress) {
            case 0:
                return "Factivel";
                break;
            case 1:
                return "Sucesso";
                break;
            case 2:
                return "Error no processamento";
                break;
        }
    }
        
    public function timeElapsedString($full = false)
    {
        $now = Carbon::now('America/Sao_Paulo'); //Your timezone
        $ago = Carbon::createFromTimeStamp(strtotime($this->updated_at));
        $diff = $now->diff(new \DateTime($ago));
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = [
            'y' => 'ano',
            'm' => 'mês',
            'w' => 'semana',
            'd' => 'dia',
            'h' => 'hora',
            'i' => 'minuto',
            's' => 'segundo',
        ];
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' atrás' : 'agora mesmo';
    }
}