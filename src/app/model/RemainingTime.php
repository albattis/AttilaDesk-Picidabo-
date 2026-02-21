<?php

namespace app\model;

use DateInterval;
use DateTime;
use db\Database;
use PDO;



class RemainingTime
{
    private $id;
    private $type;
    private $days;

private function daycounter(DateTime $date)
{
    return $date->format("d");
}

    public static function countDown($id,$recordingTime)
    {

        $time=self::findOneByIdTime($id);

        $datenow=new DateTime();
        $dateremaining = DateTime::createFromFormat('Y-m-d H:i:s.u', $recordingTime);
        $dateremaining->modify('+'.$time.' day');

        if($dateremaining<$datenow) //lejárt
        {
            $expiredtime=$dateremaining->diff($datenow);
            if($expiredtime->y >0)
            {
                ?><div class="expired-time"><?=$expiredtime->y?> év <?=$expiredtime->m ?> hónap <?=$expiredtime->d ?> napja lejárt.</div>
                <script>alert("A Feladat lejárt. További intézkedést igényel.")</script>
                <?php
            }
            elseif($expiredtime->m>0)
            {
                ?><div class="expired-time"> <?=$expiredtime->m ?> hónap <?=$expiredtime->d ?> napja lejárt.</div>
                <script>alert("A Feladat lejárt. További intézkedést igényel.")</script>
                <?php
            }
            elseif($expiredtime->d>0)
            {
                ?><div class="expired-time"><?=$expiredtime->d ?> napja lejárt.</div>
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
            $expiredtime=$datenow->diff($dateremaining);
            if($expiredtime->y >0)
            {
                ?><div class="ok-time"><?=$expiredtime->y?> év <?=$expiredtime->m ?> hónap <?=$expiredtime->d ?> napp múlva lejár.</div>

                <?php
            }
            elseif($expiredtime->m>0)
            {
                ?><div class="ok-time"> <?=$expiredtime->m ?> hónap <?=$expiredtime->d ?> nap múlva lejár.</div>

                <?php
            }
            else
            {
                if($expiredtime->d>5)
                {
                    ?><div class="ok-time"><?=$expiredtime->d ?> nap múlva lejár.</div>

                    <?php
                }
                elseif($expiredtime->d>=1 && $expiredtime->d<=4)
                {
                    ?><div class="warning-time"><?=$expiredtime->d ?> nap múlva lejár.</div>

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