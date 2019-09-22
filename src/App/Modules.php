<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App;

/**
 * list and name of application's modules
 * Class Modules
 * @package App
 * @author bernard-ng, https://bernard-ng.github.io
 */
abstract class Modules
{
    public const GALLERY = "gallery";
    public const USERS = "users";
    public const NEWSLETTER = "newsletter";
    public const PODCASTLINKS = "podcastLinks";
    public const PODCASTS = "podcasts";
    public const CATEGORIES = "categories";
    public const PODCASTLINKS_TABLE = "podcast_links";
}
