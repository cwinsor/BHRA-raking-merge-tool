<?php

/**
 * Interface InterfaceRowSchedulable
 * The interface defines methods to see if the [customer, volunteer]
 * is available to be scheduled on that date/time.
 * It also defines methods to assign the [customer, volunteer] to a team on that date/time.
 *
 * Note that availability is different than assignment - availability comes from
 * the original source, whereas assignment is made later.  It is possible (likely)
 * to have availability but no assignment,  or assignment but no availability
 * or even assignment and availability that do not match.
 */
interface InterfaceRowSchedulable
{
    public function isAvailable($day, $startTime);

    public function isAssigned($day, $startTime);

    public function isAssignedTeam($day, $startTime, $teamNumber);

    public function assign($day, $startTime, $teamNumber);

    public function unAssign();

}
