<?php
/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2015 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * NOTICE:
 *
 * If you need to make modifications to the default configuration, copy
 * this file to your app/config folder, and make them in there.
 *
 * This will allow you to upgrade fuel without losing your custom config.
 */
return array(

  /**
   * DB connection, leave null to use default
   */
  'db_connection' => null,

  /**
   * DB write connection, leave null to use same value as db_connection
   */
  'db_write_connection' => null,

  /**
   * DB table name for the user table
   */
  'table_name' => 'users',

  /**
   * Choose which columns are selected, must include: username, password, email, last_login,
   * login_hash, group & profile_fields
   */
  'table_columns' => array('*'),

  /**
   * This will allow you to use the group & acl driver for non-logged in users
   */
  'guest_login' => true,

  /**
   * This will allow the same user to be logged in multiple times.
   *
   * Note that this is less secure, as session hijacking countermeasures have to
   * be disabled for this to work!
   */
  'multiple_logins' => false,

  /**
   * Remember-me functionality
   */
  'remember_me' => array(
    /**
     * Whether or not remember me functionality is enabled
     */
    'enabled' => false,

    /**
     * Name of the cookie used to record this functionality
     */
    'cookie_name' => 'sl_cookie',

    /**
     * Remember me expiration (default: 31 days)
     */
    'expiration' => 86400 * 31,
  ),

  /**
   * Groups as id => array(name => <string>, roles => <array>)report_contribute
   */
  'groups' => array(
    -1   => array('name' => 'Banned（削除）', 'roles' => array(
        'banned'
    )),
    0    => array('name' => 'Guests', 'roles' => array()),
    1    => array('name' => 'メンバー', 'roles' => array(
        'user'
    )),
    2    => array('name' => '一般オフィシャルメンバー', 'roles' => array(
        'general_official_member'
    )),
    30   => array('name' => '（旧）オフィシャルメンバー', 'roles' => array(
        'user',
        'official_member',
        'joshikai_contribute',
        'report_contribute'
    )),
    40   => array('name' => '編集部', 'roles' => array(
        'user',
        'editor',
        'joshikai_admin',
        'report_admin'
    )),
    41   => array('name' => '(新）オフィシャルメンバー', 'roles' => array(
        'user',
        'official_member',
        'joshikai_contribute',
        'report_contribute'
    )),
    42   => array('name' => '法人', 'roles' => array(
        'user',
        'corporate',
        'joshikai_contribute',
        'report_contribute'
    )),
    80   => array('name' => '管理者（削除）', 'roles' => array(
        'user',
        'official_member',
        'joshikai_admin',
        'report_admin',
        'admin'
    )),
    100  => array('name' => '社員・事務局', 'roles' => array(
        'user',
        'official_member',
        'joshikai_admin',
        'report_admin',
        'admin',
        'super_admin'
    )),
  ),

  /**
   * Roles as name => array(location => rights)
   */
  'roles' => array(
    'admin' => array(
      'admin' => array('read'),
      'analysis' => array('read'),
//      'applications' => array('read'),
      'authors' => array('read', 'create', 'edit', 'delete'),
      'otherauthors' => array('read', 'create', 'edit', 'delete'),
      'blogs' => array('read', 'create', 'edit', 'delete', 'publish'),
      'events' => array('read', 'create', 'edit', 'delete'),
      'applications' => array('read', 'create', 'edit', 'delete'),
      'inquiries' => array('read'),
      'consultations' => array('read'),
      'news' => array('read', 'create', 'edit', 'delete', 'publish'),
      'registlist' => array('read', 'create'),
      'registreminder' => array('send'),
      'remindmailtemplates' => array('read', 'edit'),
      'userblogs' => array('read', 'create', 'edit', 'delete'),
    ),
    'super_admin' => array(
      'staffs' => array('read', 'edit'),
    ),
    'joshikai_admin' => array(
      'admin' => array('read'),
      'events' => array('read', 'create', 'edit', 'publish'),
      'analysis' => array('read'),
      'applications' => array('read'),
    ),
    'report_admin' => array(
      'admin' => array('read'),
      'blogs' => array('read', 'create', 'edit', 'publish'),
    ),
    'editor' => array(
      'authors' => array('read', 'create', 'edit', 'delete'),
      'userblogs' => array('read', 'create', 'edit', 'delete'),
    ),
    'joshikai_contribute' => array(
      'admin' => array('read'),
      'events' => array('read', 'create', 'edit'),
      'analysis' => array('read'),
      'applications' => array('read'),
    ),
    'report_contribute' => array(
      'admin' => array('read'),
      'blogs' => array('read', 'create', 'edit'),
    ),
    'official_member' => array(
      'authors' => array('read', 'create', 'edit', 'delete'),
      'userblogs' => array('read', 'create', 'edit', 'delete'),
    ),
    'corporate' => array(
      'authors' => array('read', 'create', 'edit', 'delete'),
      'userblogs' => array('read', 'create', 'edit', 'delete'),
    ),
    'user' => array(
      'authors' => array('read', 'create', 'edit', 'delete'),
      'userblogs' => array('read', 'create', 'edit', 'delete'),
    ),
    'general_official_member' => array(
      'authors' => array('read', 'create', 'edit', 'delete'),
      'userblogs' => array('read', 'create', 'edit', 'delete'),
    ),

    /**
     * Examples
     * ---
     *
     * Regular example with role "user" given create & read rights on "comments":
     *   'user'  => array('comments' => array('create', 'read')),
     * And similar additional rights for moderators:
     *   'moderator'  => array('comments' => array('update', 'delete')),
     *
     * Wildcard # role (auto assigned to all groups):
     *   '#'  => array('website' => array('read'))
     *
     * Global disallow by assigning false to a role:
     *   'banned' => false,
     *
     * Global allow by assigning true to a role (use with care!):
     *   'super' => true,
     */
  ),

  /**
   * Salt for the login hash
   */
  'login_hash_salt' => 'VoOJeVC9SG7MxEGh',

  /**
   * $_POST key for login username
   */
  'username_post_key' => 'username',

  /**
   * $_POST key for login password
   */
  'password_post_key' => 'password',
);
