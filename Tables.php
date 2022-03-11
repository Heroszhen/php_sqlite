<?php

class Tables
{
    /**
     * php pdo read one file .sql to create tables in database
     * @param PDO $pdo
     * @param string $filesql path of file that contains SQLite script
     */
    public static function createTables(PDO $pdo, string $filesql)
    {
        $sql = file_get_contents($filesql);

        if ($pdo->exec($sql) === false) {
            die(print_r($pdo->errorInfo(), true));
        }
    }

    /**
     * drop all tables in one database
     * @param PDO $pdo
     * @param string $filesql path of file that contains SQLite script
     */
    public static function emptyBDD(PDO $pdo)
    {
        $query = $pdo->prepare("SELECT name FROM sqlite_master WHERE type='table';");
        $query->execute();
        $alltables = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($alltables as $one) {
            $query2 = $pdo->prepare("DROP TABLE " . $one['name']);
            if ($query2 != false) $query2->execute();
        }
    }

    public static function exec(PDO $pdo, string $query, array $params = []): object
    {
        // Sanitize
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $params[$key] = trim(strip_tags($value));
            }
        }

        $r = $pdo->prepare($query);
        $r->execute($params);
        if (!empty($r->errorInfo()[2])) {
            die('Erreur rencontrée lors de la requête : ' . $r->errorInfo()[2]);
        }

        return $r;
    }
}
