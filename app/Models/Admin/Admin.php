<?php

namespace AVDPainel\Models\Admin;

use AVDPainel\Notifications\AdminResetPasswordNotification;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * Notifica o usuário e envia um token para alterar a senha.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

    /**
     * Permite apenas estes campos.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'login',
        'profile',
        'phone',
        'email',
        'active',
        'commission',
        'percent',
        'last_url',
        'password',
        'image'
    ];

    /**
     * Os atributos que devem ser escondidos para os array.
     *
     * @var array
     */
    protected $hidden = [
        'login', 'password', 'remember_token',
    ];

    /**
     *  Data de exclusão do registro
     */
    protected $dates = ['deleted_at'];

    /**
     * Se o password estiver no campo aplica a criptografia automáticamente
     * Retorna email com todos os caracteres convertidos para minúsculas.
     *
     * @param array $attributes
     * @return $this
     */
    public function fill(array $attributes)
    {
        !isset($attributes['password']) ?: $attributes['password'] = bcrypt($attributes['password']);
        !isset($attributes['email']) ?: $attributes['email'] = strtolower($attributes['email']);

        return parent::fill($attributes);
    }

    /**
     * Retorna o acesso ip última url etc...
     * @return array
     **/

    public function accesses()
    {
        return $this->hasMany(AdminAccess::class);
    }

    /**
     * Usuários vinculados ao perfil
     * @return array
     **/
    public function profiles()
    {
        return $this->belongsToMany(ConfigProfile::class);
    }



    /**
     * Permissões vinculadas
     * @return array
     **/
    public function permissions()
    {
        return $this->hasMany(AdminPermission::class);
    }

    /**
     * Foto do perfil do usuário
     * @return array
     **/
    public function photo()
    {
        return $this->hasMany(ImageAdmin::class, 'admin_id');
    }

}