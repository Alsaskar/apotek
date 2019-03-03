<?php

class Database {

    protected $conn;

    public function __construct($connect){
        $this->conn = $connect;
    }

    // fungsi insert data ke database
    public function insert($tabel, $values = array()){
        
        foreach ($values as $field => $v)
            $ins[] = ':' . $field;

        $ins = implode(',', $ins);
        $fields = implode(',', array_keys($values));
        $sql = "INSERT INTO $tabel ($fields) VALUES ($ins)";

        $sth = $this->conn->prepare($sql);
        foreach ($values as $f => $v){
            $sth->bindValue(':' . $f, $v);
        }

        $sth->execute();
    }

    // fungsi untuk mengedit data
    public function update($table, $columns, $data, $where) {

        error_reporting(0);

        foreach ( $columns as $column ){
            $update .= " " . $column . " = :" . $column . ", ";
        }
        
        $update = trim($update, ", ");
        $where_prepare = " " . $where[0] . " = :" . $where[0];
        $prepare = "UPDATE {$table} SET {$update} WHERE {$where_prepare}";

        $counter = 0;
        $execute_data = array();

        foreach ( $columns as $column ) {
            $execute_data[":{$column}"] = $data[$counter];
            $counter++;
        }

        $where_0 = $where[0];
        $execute_data[":{$where_0}"] = $where[1];

        $stmt = $this->conn->prepare($prepare);
        $stmt->execute($execute_data);

        if ( $stmt->rowCount() > 1 ) {
            return true;
        }else{
            return false;
        }
    }

    // fungsi menampilkan data
    public function select($tabel, $where = "", $value = "", $order = "", $limit = "", $where2 = "", $value2 = ""){

        if ($where != "" && $value != "") { // jika where dan value tidak kosong, maka


            if ($order != "") { // jika parameter order tidak kosong

                if ($limit != "") { // jika parameter limit tidak kosong, maka

                    if ($where2 != "" && $value2 != "") { // jika where 2 tidak kosong

                        // tampilkan data berdasarkan yang di tentukan
                        $sql = "SELECT * FROM $tabel WHERE $where = :$where AND $where2 = :$where2 ORDER BY $order DESC LIMIT $limit";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->execute(array(":$where" => $value, ":$where2" => $value2));

                        return $stmt;
                    }else{ // jika where 2 kosong
                        // tampilkan data tetapi datanya di limit atau di beri batasan
                        $sql = "SELECT * FROM $tabel WHERE $where = :$where ORDER BY $order DESC LIMIT $limit";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->execute(array(":$where" => $value));

                        return $stmt;
                    }

                }else{ // jika parameter limit kosong, maka

                    if ($where2 != "" && $value2 != "") { // jika where dan value tidak kosong
                        // tampilkan data dari terbesar ke terkecil
                        $sql = "SELECT * FROM $tabel WHERE $where = :$where AND $where2 = :$where2 ORDER BY $order DESC";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->execute(array(":$where" => $value, ":$where2" => $value2));

                        return $stmt;
                        
                    }else{ // jika keduanya kosong

                        // tampilkan data dari terbesar ke terkecil
                        $sql = "SELECT * FROM $tabel WHERE $where = :$where ORDER BY $order DESC";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->execute(array(":$where" => $value));

                        return $stmt;
                    }

                }

            }else{ // jika parameter order kosong
                
                // tampilkan data berdasarkan yang di tentukan
                $sql = "SELECT * FROM $tabel WHERE $where = :$where";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(array(":$where" => $value));

                return $stmt;
            }

        }else{ // jika where dan value kosong, maka

            // tampilkan seluruh data pada tabel
            $sql = "SELECT * FROM $tabel";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }
    }

    // fungsi menghapus data
    public function delete($tabel, $where = "", $value = ""){

        if ($where != "" && $value != "") { // jika where dan value tidak kosong, maka

            // hapus data berdasarkan yang di tentukan
            $sql = "DELETE FROM $tabel WHERE $where = :$where";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array(":$where" => $value));

            return $stmt;
        }else{ // jika where dan value kosong, maka

            // hapus seluruh data pada tabel
            $sql = "DELETE FROM $tabel";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

    }

    // fungsi cari
    public function cari($tabel, $where, $cari, $where2, $value2){
        $query = $this->conn->prepare("SELECT * FROM $tabel WHERE $where LIKE :cari AND $where2 = :$where2 ORDER BY id DESC");
        $query->execute(array(":cari" => '%'.$cari.'%', ":$where2" => $value2));

        return $query;
    }

    // fungsi pagination
    public function pagination($tabel, $where, $value, $order, $start, $perPage, $where2 = "", $value2 = ""){
        try{

            // ini statement untuk membuat pagination berdasarkan yang di cari
            if ($where2 != "" && $value2 != "") { // jika $where2 dan $value2 tidak kosong, maka

                // kita membuat query LIKE
                $query = $this->conn->prepare("SELECT * FROM $tabel WHERE $where LIKE :cari AND $where2 = :$where2 ORDER BY id DESC LIMIT $start, $perPage");
                $query->execute(array(":cari" => '%'.$value.'%', ":$where2" => $value2));

                return $query;
            }else{
                $query = $this->conn->prepare("SELECT * FROM $tabel WHERE $where = :$where ORDER BY $order DESC LIMIT $start, $perPage");
                $query->execute(array(":$where" => $value));

                return $query;
            }

            
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    // fungsi kode otomatis untuk primary key
    public function kode_otomatis($tabel, $field, $inisial){
        $query = $this->conn->prepare("SELECT MAX($field) AS maxKode FROM $tabel");
        $query->execute();

        $row_kode = $query->fetch();
        $kode = $row_kode['maxKode'];

        $noUrut = (int) substr($kode, 5, 5);
        $noUrut++;

        $char = $inisial;
        return $newID = $char . sprintf("%05s", $noUrut);
    }

}

?>