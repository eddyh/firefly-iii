<?php
/**
 * ChartBudgetControllerTest.php
 * Copyright (C) 2016 Sander Dorigo
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */
use Carbon\Carbon;
use FireflyIII\Models\Budget;
use Illuminate\Support\Collection;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-01-19 at 15:39:57.
 */
class ChartBudgetControllerTest extends TestCase
{

    /**
     * @covers FireflyIII\Http\Controllers\Chart\BudgetController::budget
     * @covers FireflyIII\Http\Controllers\Chart\BudgetController::__construct
     */
    public function testBudget()
    {

        $repository = $this->mock('FireflyIII\Repositories\Budget\BudgetRepositoryInterface');
        $repository->shouldReceive('spentPerDay')->once()->andReturn([]);
        $repository->shouldReceive('getFirstBudgetLimitDate')->once()->andReturn(new Carbon);

        $this->be($this->user());
        $this->call('GET', '/chart/budget/1');
        $this->assertResponseStatus(200);
    }

    /**
     * @covers FireflyIII\Http\Controllers\Chart\BudgetController::budgetLimit
     */
    public function testBudgetLimit()
    {
        $this->be($this->user());
        $this->call('GET', '/chart/budget/1/1');

        $this->assertResponseStatus(200);
    }

    /**
     * @covers FireflyIII\Http\Controllers\Chart\BudgetController::frontpage
     */
    public function testFrontpage()
    {
        $this->be($this->user());
        $this->call('GET', '/chart/budget/frontpage');

        $this->assertResponseStatus(200);
    }

    /**
     * @covers FireflyIII\Http\Controllers\Chart\BudgetController::multiYear
     */
    public function testMultiYear()
    {

        $budget                = new Budget;
        $budget->id            = 1;
        $budget->dateFormatted = '2015';
        $budget->budgeted      = 120;

        $repository = $this->mock('FireflyIII\Repositories\Budget\BudgetRepositoryInterface');
        $repository->shouldReceive('getBudgetedPerYear')->once()->andReturn(new Collection([$budget]));
        $repository->shouldReceive('getBudgetsAndExpensesPerYear')->once()->andReturn([]);

        $this->be($this->user());
        $this->call('GET', '/chart/budget/multi-year/default/20150101/20160101/1/1');
        $this->assertResponseStatus(200);

    }

    /**
     * @covers FireflyIII\Http\Controllers\Chart\BudgetController::year
     */
    public function testYear()
    {
        $repository = $this->mock('FireflyIII\Repositories\Budget\BudgetRepositoryInterface');
        $repository->shouldReceive('getBudgetsAndExpensesPerMonth')->once()->andReturn([]);

        $this->be($this->user());
        $this->call('GET', '/chart/budget/year/default/20150101/20151231/1');
        $this->assertResponseStatus(200);

    }
}
