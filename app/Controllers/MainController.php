<?php

namespace App\Controllers;

use Framework\View;
use Framework\Controller;
use App\Helpers\AuthHelper;
use App\Helpers\SessionHelper as Session;
use App\Helpers\TraitsHelper as Traits;
use App\Models\Petition;
use App\Models\UserPetition;
use App\Models\User;
use Twig_Environment;
use DateTime;

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
        $title = APP_TITLE . ' :: Вхід';

        $this->getAllPetitions($petitions);

        $isAuth = $this->userAuth;
        $userId = Session::getUserId();

        echo View::template('startPage.twig', compact('title', 'petitions', 'isAuth', 'userId'));
    }

    private function getAllPetitions(&$petitions) {
        $petitions = new Petition();
        
        $petitions = $petitions
            ->select()
            ->where('id', '=', 1)
            ->whereOR()
            ->where('id', '>=', 8)
            ->orderBy('created_date', 'DESC')
            ->get();
            
        //$petitions = $petitions->all('DESC', 'created_date');

        foreach($petitions as &$petition)
        {
            $signatures = new UserPetition();
            $signatures = $signatures
                            ->select()
                            ->where('petition_id', $petition['id'])
                            ->get();
            
            $petition['signature'] = count($signatures);
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
                $user = new User();
                $user->login = 'testUser';
                $user->last_name = 'Иванов';
                $user->first_name = 'Иван';
                $user->midle_name = 'Иванович';
                $user->email = 'ivanov@ivan.iv';
                $user->password = password_hash('testUser32', PASSWORD_DEFAULT);
                $user->confirmed = 1;
                $user->save();

                $user = new User();
                $user->login = 'testUser2';
                $user->last_name = 'Петров';
                $user->first_name = 'Петр';
                $user->midle_name = 'Петровичнович';
                $user->email = 'petrov@petr.ptr';
                $user->password = password_hash('testUser23', PASSWORD_DEFAULT);
                $user->confirmed = 1;
                $user->save();
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
                $date = new DateTime("NOW");
                $newPetition = new Petition();
                $newPetition->title = 'Заборонити політичну рекламу в засобах масової інформації.';
                $newPetition->petition_text = 'Прохання заборонити політичну рекламу в засобах масової інформації. Враховуючи засилля політичної реклами окремих політсил на телебаченні, радіо та інших ЗМІ, виникає ситуація, що свідомістю громадян свідомо маніпулюють (вводять в оману) в підтримку окремого кандидата, коли громадяни не мають доступу до інших альтернативних джерел інформації, а це більшість громадян України.';
                $newPetition->owner_id = 1;
                $newPetition->created_date = $date->format('Y-m-d H:i:s');
                $newPetition->save();
                
                $newPetition = new Petition();
                $newPetition->title = 'Не допустити збільшення оподаткування на посилки фізичних осіб';
                $newPetition->petition_text = 'Просимо не допустити збільшення оподаткування на посилки фізичних осіб, отримані з-за кордону шляхом застосування права вето Глави держави у разі прийняття відповідних законів Верховною Радою України.';
                $newPetition->owner_id = 1;
                $newPetition->created_date = $date->format('Y-m-d H:i:s');
                $newPetition->save();

                $newPetition = new Petition();
                $newPetition->title = 'СПОСОБСТВОВАТЬ УМЕНЬШЕНИЮ ИНФЛЯЦИИ';
                $newPetition->petition_text = 'ПОВЫСИТЬ УЧЕТНУЮ СТАВКУ НБУ И ПРИНЯТЬ ДРУГИЕ МЕРЫ ДЛЯ ТОГО ЧТО БЫ УМЕНЬШИТЬ ИНФЛЯЦИЮ. ЭТО НЕ ДЕЛО ЧТО ЗАРПЛАТЫ И ПЕНСИИ ЛЮДЕЙ ОБЕСЦЕНИВАЮТСЯ ТАК БЫСТРО. СЕЙЧАС ЭКОНОМИЧЕСКИЙ РОСТ В СТРАНЕ ДОСТАТОЧНО ВЫСОКИЙ И ПРИНЯТИЕ МЕР ДЛЯ УМЕНЬШЕНИЯ ИНФЛЯЦИИ НЕ ПРИВЕДЕТ К ЕГО РЕЗКОМУ ЗАМЕДЛЕНИЮ. УСТАНОВИТЬ ЦЕЛЬ ПО ИНФЛЯЦИИ НА 2019 ГОД НА УРОВНЕ НЕ ВЫШЕ 4%.';
                $newPetition->owner_id = 2;
                $newPetition->created_date = $date->format('Y-m-d H:i:s');
                $newPetition->save();

                $newPetition = new Petition();
                $newPetition->title = 'Забовязати в державних та приватних підприємствах вішати на вході дзеркало.';
                $newPetition->petition_text = 'Задля покращення робочих умов необхідно забовязати в державних та приватних підприємствах вішати на вході дзеркало.';
                $newPetition->owner_id = 2;
                $newPetition->created_date = $date->format('Y-m-d H:i:s');
                $newPetition->save();

                $newPetition = new Petition();
                $newPetition->title = 'Виїзд швидкої до усіх звернень!';
                $newPetition->petition_text = 'Суть цієї петиції дати змогу простому народу відчути себе в безпеці в своїй країні (Україні)
                Зараз розглядається закон про Швидку який полягає в тому що вона (швидка) має виїжджати лише на виклики від родичів ...тобто наприклад мені погано і причина викликати швидку реальна ...то викликати мені її можуть лише родичі! Не друзі не знайомі і не прохожі 
                Як вам такий закон?(риторичне питання яке не потребує відповіді ) Як в таких умовах можна відчувати себе спокійно?-ніяк 
                Тепер живий приклад ...студент...гуртожиток...всі люди з різних міст, областей і т д(не родичі) ...одній людині стало погано у неї стався напад ...підвищення температури почало трясти ...не мігла встати на ноги ...швидку викликало ~до20 людей і на всі прохання вони відмовляли зі словами " ви його родич" і лише на виклик від вахтера гуртожитку швидка приїхала 
                З життям не потрібно гратись особливо з чужим (ці слова до тих хто приймає такі закони) 
                Дякую за розуміння
                Викликати швидку повинен мати змогу кожен ...не кожен може зупинити ту саму температуру чи ще щось гірше ...
                Сподіваюсь суть петиції зрозуміла 
                Будеріть себе та своє здоров\'я.';
                $newPetition->owner_id = 2;
                $newPetition->created_date = $date->format('Y-m-d H:i:s');
                $newPetition->save();
                
                $newPetition = new Petition();
                $newPetition->title = 'Національна ідея України.';
                $newPetition->petition_text = 'Головними наслідками діяльності радянського уряду в Україні в період 1917-1991р.р. визнано Законами України та Державами світу: Геноцид, 50 млн. зниклих в результаті червоного терору, примусова праця та злидні.
                Головними наслідками діяльності урядів України в період 1991-2018р.р стало: міграція з України до 10 млн. українців, біженці та самий низький в Європі життєвий рівень української сім’ї. 
                Пропонуємо розробити програму «Подолання наслідків діяльності урядів України в період 1917-2017р.р.», та формування Національної ідеї України «Українська сім’я - Здорова, Заможна, Захищена, Забезпечена Золотим Запасом Зерна Землі».';
                $newPetition->owner_id = 2;
                $newPetition->created_date = $date->format('Y-m-d H:i:s');
                $newPetition->save();

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
                $up = new UserPetition();
				$up->user_id = 1;
				$up->petition_id = 1;
                $up->save();
                
                $up = new UserPetition();
				$up->user_id = 1;
				$up->petition_id = 2;
                $up->save();
                
                $up = new UserPetition();
				$up->user_id = 1;
				$up->petition_id = 3;
                $up->save();
                
                $up = new UserPetition();
				$up->user_id = 1;
				$up->petition_id = 4;
                $up->save();
                
                $up = new UserPetition();
				$up->user_id = 1;
				$up->petition_id = 5;
                $up->save();
                
                $up = new UserPetition();
				$up->user_id = 1;
				$up->petition_id = 6;
                $up->save();
                
                $up = new UserPetition();
				$up->user_id = 2;
				$up->petition_id = 1;
                $up->save();

                $up = new UserPetition();
				$up->user_id = 2;
				$up->petition_id = 2;
                $up->save();
                
                $up = new UserPetition();
				$up->user_id = 2;
				$up->petition_id = 3;
                $up->save();
                
                $up = new UserPetition();
				$up->user_id = 2;
				$up->petition_id = 4;
				$up->save();
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