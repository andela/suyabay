<?php

namespace Suyabay\Http\Controllers\Api\Utility;

trait Utility 
{
    /**
     * This method validate channel request.
     *
     * @param $pageLimit
     * @param $request
     *
     * @return $recordsToSkip
     */
    public function getRecordsToSkip($pageLimit, $request)
    {
        $page = $request->query('page') ? : 1;
        $recordsToSkip = (int) ($pageLimit * $page) - $pageLimit;

        return $recordsToSkip;
    }
}
