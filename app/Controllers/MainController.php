<?php

namespace App\Controllers;

use Framework\View;
use Framework\Controller;
use App\Helpers\AuthHelper;
use App\Helpers\Session;
use App\Helpers\TraitsHelper as Traits;
use App\Models\Petition;
use App\Models\UserPetition;
use App\Models\User;
use Twig_Environment;

class MainController extends Controller
{
    private $userAuth;

    protected function before()
    {
        
        $this->prepareDB();

    	if (AuthHelper::Auth())
    	{
            $this->userAuth = true;
        }
        else
        {
            $this->userAuth = false;
        }
    }

    public function index()
    {
        $date = new \DateTime("NOW");
        $petition = new Petition();
        $petition->title = "New Petition" . time();
        // $petition->petition_text = "Lorem Ipsum - это текст-\"рыба\", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной \"рыбой\" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов. Lorem Ipsum не только успешно пережил без заметных изменений пять веков, но и перешагнул в электронный дизайн. Его популяризации в новое время послужили публикация листов Letraset с образцами Lorem Ipsum в 60-х годах и, в более недавнее время, программы электронной вёрстки типа Aldus PageMaker, в шаблонах которых используется Lorem Ipsum.";
        $petition->petition_text = "Lorem Ipsum";
        $petition->owner_id = '3';
        $petition->created_date = $date->format("Y-m-d H:i:s");
        $petition->save();

        $title = APP_TITLE . ' :: Вхід';

        $this->getAllPetitions($petitions);

        $isAuth = $this->userAuth;

        echo View::template('startPage.twig', compact('title', 'petitions', 'isAuth'));

        //return View::render('startPage', compact('title', 'petitions', 'isAuth'));
    }

    public function error5($msg) {
        $error['message'] = $msg;
        echo View::template('error500.twig', compact('error'));
    }

    private function getAllPetitions(&$petitions) {
        $petitions = new Petition();
        $petitions = $petitions->getAllPetitions();

        foreach($petitions as &$petition)
        {
            $petition['signature'] = UserPetition::getPetitionSignatures($petition['id']);
        }
    }

    private function prepareDB() {
        $user = new User();
        $petition = new Petition();
        $userPetition = new UserPetition();

        if (!$user->tableExist())
        {
            if ($user->newTable())
            {
                $user->createUser([
                    'login' => 'testUser',
                    'last_name' => 'Иванов' ,
                    'first_name' => 'Иван' ,
                    'midle_name' => 'Иванович' ,
                    'email' => 'ivanov@ivan.iv',
                    'password' => 'testUser32',
                    'confirmed' => 1
                ]);
                $user->createUser([
                    'login' => 'testUser2',
                    'last_name' => 'Петров' ,
                    'first_name' => 'Петр' ,
                    'midle_name' => 'Петрович' ,
                    'email' => 'petrov@petr.ptr',
                    'password' => 'testUser23',
                    'confirmed' => 1
                ]);
            }
            else
            {
                echo ('Таблица пользователи не создана!');
            }
        }

        if (!$petition->tableExist())
        {
            if ($petition->newTable())
            {
                $petition->createPetition([
                    'title' => 'Заборонити політичну рекламу в засобах масової інформації.',
                    'petition_text' => 'Прохання заборонити політичну рекламу в засобах масової інформації. Враховуючи засилля політичної реклами окремих політсил на телебаченні, радіо та інших ЗМІ, виникає ситуація, що свідомістю громадян свідомо маніпулюють (вводять в оману) в підтримку окремого кандидата, коли громадяни не мають доступу до інших альтернативних джерел інформації, а це більшість громадян України.',
                    'owner_id' => 1,
                ]);
                $petition->createPetition([
                    'title' => 'Не допустити збільшення оподаткування на посилки фізичних осіб',
                    'petition_text' => 'Просимо не допустити збільшення оподаткування на посилки фізичних осіб, отримані з-за кордону шляхом застосування права вето Глави держави у разі прийняття відповідних законів Верховною Радою України.',
                    'owner_id' => 1,
                ]);
                $petition->createPetition([
                    'title' => 'СПОСОБСТВОВАТЬ УМЕНЬШЕНИЮ ИНФЛЯЦИИ',
                    'petition_text' => 'ПОВЫСИТЬ УЧЕТНУЮ СТАВКУ НБУ И ПРИНЯТЬ ДРУГИЕ МЕРЫ ДЛЯ ТОГО ЧТО БЫ УМЕНЬШИТЬ ИНФЛЯЦИЮ. ЭТО НЕ ДЕЛО ЧТО ЗАРПЛАТЫ И ПЕНСИИ ЛЮДЕЙ ОБЕСЦЕНИВАЮТСЯ ТАК БЫСТРО. СЕЙЧАС ЭКОНОМИЧЕСКИЙ РОСТ В СТРАНЕ ДОСТАТОЧНО ВЫСОКИЙ И ПРИНЯТИЕ МЕР ДЛЯ УМЕНЬШЕНИЯ ИНФЛЯЦИИ НЕ ПРИВЕДЕТ К ЕГО РЕЗКОМУ ЗАМЕДЛЕНИЮ. УСТАНОВИТЬ ЦЕЛЬ ПО ИНФЛЯЦИИ НА 2019 ГОД НА УРОВНЕ НЕ ВЫШЕ 4%.',
                    'owner_id' => 2,
                ]);
                $petition->createPetition([
                    'title' => 'Забовязати в державних та приватних підприємствах вішати на вході дзеркало.',
                    'petition_text' => 'Задля покращення робочих умов необхідно забовязати в державних та приватних підприємствах вішати на вході дзеркало.',
                    'owner_id' => 2,
                ]);
                $petition->createPetition([
                    'title' => 'Виїзд швидкої до усіх звернень!',
                    'petition_text' => 'Суть цієї петиції дати змогу простому народу відчути себе в безпеці в своїй країні (Україні)
        Зараз розглядається закон про Швидку який полягає в тому що вона (швидка) має виїжджати лише на виклики від родичів ...тобто наприклад мені погано і причина викликати швидку реальна ...то викликати мені її можуть лише родичі! Не друзі не знайомі і не прохожі 
        Як вам такий закон?(риторичне питання яке не потребує відповіді ) Як в таких умовах можна відчувати себе спокійно?-ніяк 
        Тепер живий приклад ...студент...гуртожиток...всі люди з різних міст, областей і т д(не родичі) ...одній людині стало погано у неї стався напад ...підвищення температури почало трясти ...не мігла встати на ноги ...швидку викликало ~до20 людей і на всі прохання вони відмовляли зі словами " ви його родич" і лише на виклик від вахтера гуртожитку швидка приїхала 
        З життям не потрібно гратись особливо з чужим (ці слова до тих хто приймає такі закони) 
        Дякую за розуміння
        Викликати швидку повинен мати змогу кожен ...не кожен може зупинити ту саму температуру чи ще щось гірше ...
        Сподіваюсь суть петиції зрозуміла 
        Будеріть себе та своє здоров\'я.',
                    'owner_id' => 2,
                ]);
                $petition->createPetition([
                    'title' => 'Національна ідея України.',
                    'petition_text' => 'Головними наслідками діяльності радянського уряду в Україні в період 1917-1991р.р. визнано Законами України та Державами світу: Геноцид, 50 млн. зниклих в результаті червоного терору, примусова праця та злидні.
        Головними наслідками діяльності урядів України в період 1991-2018р.р стало: міграція з України до 10 млн. українців, біженці та самий низький в Європі життєвий рівень української сім’ї. 
        Пропонуємо розробити програму «Подолання наслідків діяльності урядів України в період 1917-2017р.р.», та формування Національної ідеї України «Українська сім’я - Здорова, Заможна, Захищена, Забезпечена Золотим Запасом Зерна Землі».',
                    'owner_id' => 2,
                ]);
            }
            else
            {
                echo ('Таблица для хранения петиций не создана!');
            }
        }

        if (!$userPetition->tableExist())
        {
            if ($userPetition->newTable())
            {
                $userPetition->createLink([
                    'user_id' => 1,
                    'petition_id' => 1
                ]);
                $userPetition->createLink([
                    'user_id' => 1,
                    'petition_id' => 2
                ]);
                $userPetition->createLink([
                    'user_id' => 1,
                    'petition_id' => 3
                ]);
                $userPetition->createLink([
                    'user_id' => 1,
                    'petition_id' => 4
                ]);
                $userPetition->createLink([
                    'user_id' => 1,
                    'petition_id' => 5
                ]);
                $userPetition->createLink([
                    'user_id' => 1,
                    'petition_id' => 6
                ]);
                $userPetition->createLink([
                    'user_id' => 2,
                    'petition_id' => 1
                ]);
                $userPetition->createLink([
                    'user_id' => 2,
                    'petition_id' => 2
                ]);
                $userPetition->createLink([
                    'user_id' => 2,
                    'petition_id' => 3
                ]);
                $userPetition->createLink([
                    'user_id' => 2,
                    'petition_id' => 4
                ]);

            }
            else
            {
                echo ('Таблица для подписей петиций не создана!');
            }
        }
    }

    protected function after()
    {

    }
}