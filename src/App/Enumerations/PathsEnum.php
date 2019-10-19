<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App\Enumerations;

/**
 * Class PathsEnum
 * @package App\Enumerations
 * @author bernard-ng <ngandubernard@gmail.com>
 */
abstract class PathsEnum
{
    public const USERS = "users";
    public const PODCASTS = "podcasts";
    public const NEWSLETTER = "newsletter";
    public const CATEGORIES = "categories";
    public const FILES = "files";
}
