<?php
interface IDatabase{
    function Load($sql);
    function Save($sql);
}