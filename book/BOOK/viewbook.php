<?php

require_once "../classes/book.php";
class Book extends Database {
    public $id="";
    public $title="";
    public $author="";
    public $genre="";
    public $publication_year="";
    

    public function addBook(){
        $sql = "INSERT INTO book(title, author,genre,publication_year) VALUE(:title, :author, :genre, :publication_year)";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication_year", $this->publication_year);

        return $query->execute();
    }

     public function viewBook($search="", $genre_filter=""){
     if (!empty($search) && !empty($genre_filter)) {
        $sql = "SELECT * FROM book WHERE title LIKE CONCAT('%', :search, '%') AND genre = :genre ORDER BY title ASC";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":search", $search);
        $query->bindParam(":genre", $genre_filter);

        } elseif (!empty($search)) {
        $sql = "SELECT * FROM book WHERE title LIKE CONCAT('%', :search, '%') ORDER BY title ASC";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":search", $search);

        } elseif (!empty($genre_filter)) {
        $sql = "SELECT * FROM book WHERE genre = :genre ORDER BY title ASC";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":genre", $genre_filter);

        } else {
        $sql = "SELECT * FROM book ORDER BY title ASC";
        $query = $this->connect()->prepare($sql);
        }

        if ($query->execute()) {
        return $query->fetchAll();
        } else {
        return null;
        }
    }

    public function isBookExist($btitle){
        $sql = "SELECT COUNT(*) as total FROM book WHERE title = :title";
        $query= $this->connect()->prepare($sql);
        $query->bindParam(":title", $btitle);
        $record = null;
        if($query->execute()){
            $record = $query->fetch();
        }

        if($record["total"] > 0){
            return true;
        }else{
            return false;
        }
        

    }
}

// $obj = new Book();
// $obj->title = "Cinderella";
// $obj->author = "Ferrer";
// $obj->genre = "Fiction";
// $obj->publication_year=1990's;

// $obj->addBook();
