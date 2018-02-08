<?php

namespace Dynamic\Jobs\Admin;

use Dynamic\Jobs\Model\JobCategory;
use Dynamic\Jobs\Model\JobSubmission;
use SilverStripe\Admin\ModelAdmin;

/**
 * Class JobAdmin
 * @package Dynamic\Jobs\Admin
 */
class JobAdmin extends ModelAdmin
{
    /**
     * @var array
     */
    private static $managed_models = [
        JobSubmission::class,
        JobCategory::class,
    ];

    /**
     * @var string
     */
    private static $url_segment = 'jobs';

    /**
     * @var string
     */
    private static $menu_title = 'Jobs';
}
