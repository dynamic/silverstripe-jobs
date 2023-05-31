<?php

namespace Dynamic\Jobs\Page;

use \PageController;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\Control\HTTPRequest;

/**
 * Class JobCollectionController
 * @package Dynamic\Jobs\Model
 */
class JobCollectionController extends PageController
{
    /**
     * @param HTTPRequest|null $request
     * @return PaginatedList
     */
    public function PaginatedList(HTTPRequest $request = null)
    {
        if ($request === null) {
            $request = $this->owner->request;
        }
        $start = ($request->getVar('start')) ? (int) $request->getVar('start') : 0;

        $records = PaginatedList::create($this->data()->getPostedJobs(), $this->owner->request);
        $records->setPageStart($start);
        $records->setPageLength($this->data()->getCollectionSize());

        // allow $records to be updated via extension
        $this->owner->extend('updatePaginatedList', $records);

        return $records;
    }
}
