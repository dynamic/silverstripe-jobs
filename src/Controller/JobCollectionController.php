<?php

namespace Dynamic\Jobs\Page;

use \PageController;
use SilverStripe\ORM\PaginatedList;

/**
 * Class JobCollectionController
 *
 * @property JobCollection $dataRecord
 * @method JobCollection data()
 * @mixin JobCollection
 */
class JobCollectionController extends PageController
{
    /**
     * @param HTTPRequest|null $request
     * @return PaginatedList
     */
    public function PaginatedList()
    {
        $records = PaginatedList::create($this->data()->getPostedJobs(), $this->getRequest());
        $records->setPageLength($this->data()->PageSize);

        // allow $records to be updated via extension
        $this->extend('updatePaginatedList', $records);

        return $records;
    }
}
