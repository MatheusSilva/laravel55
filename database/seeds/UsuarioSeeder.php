<?php

use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
                    'name'          => 'SysTeach',
                    'email'         => 'contato@systech.com.br.email.verdadeiro',
                    'password'      => bcrypt('SistemaLaravel5.2')
                ];
        DB::table('users')->insert($user);
    }
}
