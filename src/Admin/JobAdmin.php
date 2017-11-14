<?php

namespace Dynamic\Jobs\Admin;

use Dynamic\Jobs\Model\JobCategory;
use Dynamic\Jobs\Model\JobSubmission;
use SilverStripe\Admin\ModelAdmin;

class JobAdmin extends ModelAdmin
{

    private static $managed_models = array(
        JobSubmission::class,
        JobCategory::class,
    );

    private static $url_segment = 'jobs';

    private static $menu_title = 'Jobs';
}
