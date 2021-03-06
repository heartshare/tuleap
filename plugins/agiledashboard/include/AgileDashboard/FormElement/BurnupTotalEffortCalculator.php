<?php
/**
 * Copyright (c) Enalean, 2017. All Rights Reserved.
 *
 * This file is a part of Tuleap.
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
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Tuleap\AgileDashboard\FormElement;

use Logger;
use Tuleap\Tracker\FormElement\IProvideArtifactChildrenForComputedCalculation;

class BurnupTotalEffortCalculator implements IProvideArtifactChildrenForComputedCalculation
{
    /**
     * @var BurnupManualValuesAndChildrenListRetriever
     */
    private $burnup_calculator;

    public function __construct(
        BurnupManualValuesAndChildrenListRetriever $burnup_calculator
    ) {
        $this->burnup_calculator = $burnup_calculator;
    }

    public function fetchChildrenAndManualValuesOfArtifacts(
        array $artifact_ids_to_fetch,
        $timestamp,
        $stop_on_manual_value,
        $target_field_name,
        $computed_field_id
    ) {
        return $this->burnup_calculator->getChildrenForBurnupWithComputedValuesAtGivenDate(
            $artifact_ids_to_fetch,
            $timestamp,
            false
        );
    }
}
