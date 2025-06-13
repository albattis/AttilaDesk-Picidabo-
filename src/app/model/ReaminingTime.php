<?php

namespace app\model;

use DateInterval;
use DateTime;
use db\Database;
use PDO;



class ReaminingTime
{
    private $id;
    private $type;
    private $days;

private function daycounter(DateTime $date)
{
    return $date->format("d");
}

    public static function countDown($id,$recordingTimr)
    {

        $time=ReaminingTime::findOneByIdTime($id);

        $datenow=new DateTime();
        $datereamining = DateTime::createFromFormat('Y-m-d H:i:s.u', $recordingTimr);
        $datereamining->modify('+'.$time.' day');

        if($datereamining<$datenow) //lejárt
        {
            $experierttime=$datereamining->diff($datenow);
            if($experierttime->y >0)
            {
                ?><div class="expired-time"><?=$experierttime->y?> év <?=$experierttime->m ?> hónap <?=$experierttime->d ?> napja lejárt.</div>
                <script>alert("A Feladat lejárt. További intézkedést igényel.")</script>
                <?php
            }
            elseif($experierttime->m>0)
            {
                ?><div class="expired-time"> <?=$experierttime->m ?> hónap <?=$experierttime->d ?> napja lejárt.</div>
                <script>alert("A Feladat lejárt. További intézkedést igényel.")</script>
                <?php
            }
            elseif($experierttime->d>0)
            {
                ?><div class="expired-time"><?=$experierttime->d ?> napja lejárt.</div>
                <script>alert("A Feladat lejárt. További intézkedést igényel.")</script>
                <?php
            }else
            {
                ?><div class="expired-time">A mai nap az utolsó</div>
                <script>alert("A Feladat határideje ma lejár.")</script>
                <?php
            }

        }else
        {
            $experierttime=$datenow->diff($datereamining);
            if($experierttime->y >0)
            {
                ?><div class="ok-time"><?=$experierttime->y?> év <?=$experierttime->m ?> hónap <?=$experierttime->d ?> napp múlva lejár.</div>

                <?php
            }
            elseif($experierttime->m>0)
            {
                ?><div class="ok-time"> <?=$experierttime->m ?> hónap <?=$experierttime->d ?> nap múlva lejár.</div>

                <?php
            }
            else
            {
                if($experierttime->d>5)
                {
                    ?><div class="ok-time"><?=$experierttime->d ?> nap múlva lejár.</div>

                    <?php
                }
                elseif($experierttime->d>=1 && $experierttime->d<=4)
                {
                    ?><div class="warning-time"><?=$experierttime->d ?> nap múlva lejár.</div>

                    <?php
                }
            else
                {
                    ?><div class="expired-time">A mai nap az utolsó</div>
                    <script>alert("A Feladat határideje ma lejár.")</script>
                     <?php
                }
            }
        }


    }

public static function findOneByIdTime($id)
    {
        $conn=Database::getConnection();
        $sql="select days from `tasktime` where `id` =:id";
        $statement=$conn->prepare($sql);
        $statement->execute([':id'=>$id]);
        $row=$statement->fetch(PDO::FETCH_COLUMN);
        return $row;
    }

}