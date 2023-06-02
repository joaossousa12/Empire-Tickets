<?php
    declare(strict_types = 1);

    class Faq{
        public int $id;
        public string $title;
        public string $content;

        public function __construct(int $id, string $title, string $content){
            $this->id = $id;
            $this->title = $title;
            $this->content = $content;
        }

        static function getFaqs(PDO $db) : array {
            $stmt = $db->prepare('SELECT FAQID, TITLE, CONTENT FROM FAQ');
            $stmt->execute();

            $faqs = array();
            while($faq= $stmt->fetch()){
                $faqs[] = new Faq(
                    $faq['FAQID'], 
                    $faq['TITLE'],
                    $faq['CONTENT']
                );
            }
            
            return $faqs;
        }

        static function editFaq(PDO $db, int $id, string $content) {

            $stmt = $db->prepare("UPDATE FAQ SET CONTENT = ? WHERE FAQID = ?"); 

            $stmt->execute(array($content, $id));
        
        }

        static function getContentById(PDO $db, int $id): string {
            $stmt = $db->prepare("SELECT CONTENT FROM FAQ WHERE FAQID = ?"); 

            $stmt->execute(array($id));

            if($result = $stmt->fetch()){
                return $result['CONTENT'];
            } else {
                return 'error getting content';
            }
        }

    }
?>