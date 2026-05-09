<?php

namespace App\Models;

use CodeIgniter\Model;

class AppSettingModel extends Model
{
    protected $table            = 'app_settings';
    protected $primaryKey       = 'setting_key';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['setting_key', 'setting_value'];

    protected $validationRules = [
        'setting_key' => 'required|max_length[100]',
        'setting_value' => 'required|max_length[255]',
    ];

    public function getValue(string $key, string $default = ''): string
    {
        if (! db_connect()->tableExists($this->table)) {
            return $default;
        }

        $setting = $this->find($key);

        return $setting['setting_value'] ?? $default;
    }

    public function setValue(string $key, string $value): bool
    {
        if (! db_connect()->tableExists($this->table)) {
            return false;
        }

        if ($this->find($key) === null) {
            return $this->insert([
                'setting_key' => $key,
                'setting_value' => $value,
            ]) !== false;
        }

        return $this->update($key, ['setting_value' => $value]);
    }
}
