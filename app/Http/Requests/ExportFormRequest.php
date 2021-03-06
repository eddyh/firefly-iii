<?php
declare(strict_types = 1);
/**
 * ExportFormRequest.php
 * Copyright (C) 2016 Sander Dorigo
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace FireflyIII\Http\Requests;

use Auth;
use Carbon\Carbon;

/**
 * Class ExportFormRequest
 *
 *
 * @package FireflyIII\Http\Requests
 */
class ExportFormRequest extends Request
{
    /**
     * @return bool
     */
    public function authorize()
    {
        // Only allow logged in users
        return Auth::check();
    }

    /**
     * @return array
     */
    public function rules()
    {
        $sessionFirst = clone session('first');

        $first   = $sessionFirst->subDay()->format('Y-m-d');
        $today   = Carbon::create()->addDay()->format('Y-m-d');
        $formats = join(',', array_keys(config('firefly.export_formats')));

        return [
            'export_start_range'  => 'required|date|after:' . $first,
            'export_end_range'    => 'required|date|before:' . $today,
            'accounts'            => 'required',
            'job'                 => 'required|belongsToUser:export_jobs,key',
            'accounts.*'          => 'required|exists:accounts,id|belongsToUser:accounts',
            'include_attachments' => 'in:0,1',
            'include_config'      => 'in:0,1',
            'exportFormat'        => 'in:' . $formats,
        ];
    }
}
