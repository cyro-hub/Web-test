<?php
class DataAccess
{
    public function Load($connection, $sql)
    {
        $result = $connection->query($sql);
        $connection->close();

        if ($result->num_rows > 0) {
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            return $data;
        }

        return [];
    }
    public function Save($stmt)
    {
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>