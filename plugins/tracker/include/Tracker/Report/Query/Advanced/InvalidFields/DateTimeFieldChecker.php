<?php
/**
 * Copyright (c) Enalean, 2017. All Rights Reserved.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

namespace Tuleap\Tracker\Report\Query\Advanced\InvalidFields;

use DateTime;
use Tracker_FormElement_Field;
use Tuleap\Tracker\Report\Query\Advanced\Grammar\Comparison;

class DateTimeFieldChecker implements InvalidFieldChecker
{
    public function checkFieldIsValidForComparison(Comparison $comparison, Tracker_FormElement_Field $field)
    {
        $value = $comparison->getValueWrapper()->getValue();

        $format          = "Y-m-d H:i";
        $date_time_value = DateTime::createFromFormat($format, $value);

        if ($date_time_value === false) {
            $format = "Y-m-d";
            $date_value = DateTime::createFromFormat($format, $value);

            if ($date_value === false) {
                throw new DateToStringComparisonException($field, $value);
            }
        }
    }
}