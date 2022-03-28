<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Presidente
 *
 * @property int $id
 * @property string $nome
 * @property string $numero
 * @property string $partido
 * @property string|null $imgCandidato
 * @property string|null $qtdVotos
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Presidente extends Model
{
    protected $table = 'presidente';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int'
    ];

    protected $fillable = [
        'nome',
        'numero',
        'partido',
        'imgCandidato',
        'qtdVotos'
    ];

    public function rules(): array
    {
        return [
            'nome' => 'required',
            'numero' => 'required|unique:presidente',
            'partido' => 'required',
            'imgCandidato' => 'required',
            'qtdVotos' => 'unsigned'
        ];
    }
}

