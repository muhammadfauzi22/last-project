<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter Shield.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Config;

use CodeIgniter\Shield\Config\AuthGroups as ShieldAuthGroups;

class AuthGroups extends ShieldAuthGroups
{
    /**
     * --------------------------------------------------------------------
     * Default Group
     * --------------------------------------------------------------------
     * The group that a newly registered user is added to.
     */
    public string $defaultGroup = 'pegawai';

    /**
     * --------------------------------------------------------------------
     * Groups
     * --------------------------------------------------------------------
     * An associative array of the available groups in the system, where the keys
     * are the group names and the values are arrays of the group info.
     *
     * Whatever value you assign as the key will be used to refer to the group
     * when using functions such as:
     *      $user->addGroup('superadmin');
     *
     * @var array<string, array<string, string>>
     *
     * @see https://codeigniter4.github.io/shield/quick_start_guide/using_authorization/#change-available-groups for more info
     */
    public array $groups = [
        'superadmin' => [
            'title'       => 'Super Admin',
            'description' => 'Complete control of the site.',
        ],
        'admin' => [
            'title'       => 'Admin',
            'description' => 'Day to day administrators of the site.',
        ],
        'developer' => [
            'title'       => 'Developer',
            'description' => 'Site programmers.',
        ],
        'user' => [
            'title'       => 'User',
            'description' => 'General users of the site. Often customers.',
        ],
        'pegawai' => [
            'title'       => 'Pegawai',
            'description' => 'Officers users of the site.',
        ],
        'hrd' => [
            'title'       => 'HRD',
            'description' => 'HRD users of the site.',
        ],
        'atasan' => [
            'title'       => 'Atasan',
            'description' => 'Superior officers users of the site.',
        ],
        'pengesah' => [
            'title'       => 'Pengesah',
            'description' => 'Validator users of the site.',
        ],
        'beta' => [
            'title'       => 'Beta User',
            'description' => 'Has access to beta-level features.',
        ],
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions
     * --------------------------------------------------------------------
     * The available permissions in the system.
     *
     * If a permission is not listed here it cannot be used.
     */
    public array $permissions = [
        'admin.access'        => 'Can access the sites admin area',
        'admin.settings'      => 'Can access the main site settings',
        'users.manage-admins' => 'Can manage other admins',
        'users.create'        => 'Can create new non-admin users',
        'users.edit'          => 'Can edit existing non-admin users',
        'users.delete'        => 'Can delete existing non-admin users',
        'pegawai.submission'  => 'Can open submission page',
        'pegawai.edit'        => 'Can edit submission',
        'pegawai.delete'      => 'Can delete submission',
        'pegawai.detail'      => 'Can see submission detail page',
        'pegawai.dashboard'   => 'Can see dashboard',
        'pegawai.upload'      => 'Can upload submission file',
        'atasan.approve-1'    => 'Can approve submission in first cycle',
        'atasan.reject-1'     => 'Can reject submission in first cycle',
        'atasan.revise-1'     => 'Can propose revision in first cycle',
        'hrd.monitor'         => 'Can see all submission',
        'hrd.manage-users'    => 'Can manage all users',
        'hrd.approve-2'       => 'Can approve submission in second cycle',
        'hrd.reject-2'        => 'Can reject submission in second cycle',
        'hrd.revision-2'      => 'Can propose revision in second cycle',
        'pengesah.finalize'   => 'Can finalize submission',
        'beta.access'         => 'Can access beta-level features',
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions Matrix
     * --------------------------------------------------------------------
     * Maps permissions to groups.
     *
     * This defines group-level permissions.
     */
    public array $matrix = [
        'superadmin' => [
            'admin.*',
            'users.*',
            'beta.*',
        ],
        'admin' => [
            'admin.access',
            'users.create',
            'users.edit',
            'users.delete',
            'beta.access',
        ],
        'developer' => [
            'admin.access',
            'admin.settings',
            'users.create',
            'users.edit',
            'beta.access',
        ],
        'user' => [],
        'pegawai' => ['pegawai.*'],
        'hrd' => ['pegawai.detail', 'pegawai.dashboard', 'hrd.*'],
        'atasan' => ['hrd.monitor', 'pegawai.dashboard', 'pegawai.detail', 'atasan.*'],
        'pengesah' => ['pengesah.*', 'pegawai.dashboard', 'hrd.monitor', 'pegawai.detail'],
        'beta' => [
            'beta.access',
        ],
    ];
}
