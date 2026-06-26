<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserIdentityModel;

class CreateUserByUsernameType extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Shield Custom';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'shield:create-user-by-username-type';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Menambahkan user baru menggunakan tipe identity username';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'command:name [arguments] [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $username = CLI::prompt('Masukkan Username:', null, 'required|alpha_numeric|min_length[3]');
        $password = CLI::prompt('Masukkan Password:', null, 'required|min_length[8]');
        $userProvider = auth()->getProvider();
        $createUser = new User([
            "username" => $username,
        ]);
        if (!$userProvider->save($createUser)) {
            return CLI::write('Username gagal ditambahkan!', 'red');
        }
        $user_id = $userProvider->getInsertID();
        $auth_config = config('Auth');
        $hashPassword = service('passwords')->hash($password);
        $identity_model = model(UserIdentityModel::class);
        $identities_rows = [
            "user_id" => $user_id,
            "type" => 'username',
            "secret" => $username,
            "secret2" => $hashPassword,
            "name" => null,
            "extra" => null,
            "force_reset" => 0,
        ];
        if ($identity_model->save($identities_rows)) {
            CLI::write("User $username berhasil dibuat identitas login. Gunakan username dan password untuk login!", 'green');
        } else {
            $userProvider->delete($user_id, true);
            CLI::write("User $username gagal dibuat identitas login! Coba tambahkan kembali.", 'red');
        }
    }
}
