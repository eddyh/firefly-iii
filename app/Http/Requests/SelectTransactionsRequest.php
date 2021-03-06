<?php
declare(strict_types = 1);
/**
 * SelectTransactionsRequest.php
 * Copyright (C) 2016 Robert Horlings
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
class SelectTransactionsRequest extends Request
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

        $first = $sessionFirst->subDay()->format('Y-m-d');
        $today = Carbon::create()->addDay()->format('Y-m-d');

        return [
            'start_date' => 'required|date|after:' . $first,
            'end_date'   => 'required|date|before:' . $today,
            'accounts'   => 'required',
            'accounts.*' => 'required|exists:accounts,id|belongsToUser:accounts',
        ];
    }
}
