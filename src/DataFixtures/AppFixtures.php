<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    private const USER_TEST_PASSWORD = 'password123';
    private const USER_TEST_EMAIL = 'user@test.com';

    private UserPasswordHasherInterface $hasher;

    /**
     * AppFixtures constructor.
     * @param UserPasswordHasherInterface $hasher
     */
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail(self::USER_TEST_EMAIL)
            ->setPassword($this->hasher->hashPassword($user, self::USER_TEST_PASSWORD))
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setRoles([User::USER_ROLES['ROLE_ADMIN']]);

        $manager->persist($user);

        // article
        $article = new Article();
        $article->setUser($user)
            ->setHeader('Lorem ipsum dolor sit amet')
            ->setText(
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac metus rhoncus, tempus turpis a, lobortis velit. Nulla commodo lacus leo, eu imperdiet nisi consequat a. Donec congue blandit feugiat. Vivamus dapibus semper auctor. Mauris non enim ante. Aliquam erat volutpat. Praesent egestas lectus mattis pulvinar luctus. Proin faucibus luctus erat, nec dapibus diam ultrices non. Pellentesque orci velit, interdum eget pretium quis, elementum ac est. Cras vel laoreet dui, eu aliquam orci. Nam sit amet tincidunt nibh. Proin cursus at lacus vitae egestas. Fusce sagittis turpis nec lacus sodales congue. Suspendisse vel ex ut lorem lacinia lobortis. Duis et eleifend elit. Ut convallis faucibus nisl eu dapibus.
                       Maecenas et ultrices mi. Nam scelerisque sem odio, eget sollicitudin nisl pulvinar non. Mauris lacinia magna at lectus pulvinar suscipit. Nullam at viverra tellus, ut aliquet nisi. Nam odio lorem, finibus non tortor et, vulputate aliquam lectus. Nulla suscipit condimentum tortor, a suscipit sapien sollicitudin non. Nam molestie rutrum interdum. Vivamus laoreet consectetur libero. Donec venenatis gravida orci ac dapibus. Nulla facilisi. Vestibulum gravida enim dui, quis auctor turpis dignissim vitae. Ut vel lectus a mi auctor malesuada. Praesent ac vulputate tellus.
                       Nullam semper, dolor ac elementum aliquam, nunc nibh tincidunt justo, sit amet posuere risus tortor vel ligula. Etiam euismod semper faucibus. Praesent imperdiet aliquet tellus, eu rhoncus mi efficitur venenatis. Vivamus euismod ullamcorper porttitor. Nunc sed felis a odio pharetra mattis. Fusce est sapien, pulvinar non ante ac, ullamcorper tincidunt felis. Aenean auctor hendrerit egestas. Mauris maximus mauris ante, eu imperdiet nulla ullamcorper vitae. Nulla eu bibendum neque. Maecenas blandit sed turpis ut sagittis. Maecenas vehicula viverra libero at sagittis. Phasellus quis justo ut orci aliquam iaculis sit amet quis ipsum. In at urna orci.
                       In semper semper congue. Mauris ac euismod diam, sit amet laoreet orci. Proin malesuada tincidunt porttitor. Integer consectetur feugiat posuere. Pellentesque sodales bibendum metus, sit amet finibus lectus laoreet tristique. Aenean eu odio a nibh ultricies aliquam sagittis sit amet odio. Vivamus pulvinar vestibulum rutrum. Phasellus a tellus egestas, consequat neque id, aliquam justo.
                       Vestibulum dignissim a velit id porta. Nunc auctor ex leo, ut vulputate nisl aliquam ut. Sed turpis risus, porttitor vitae tortor lobortis, posuere vestibulum leo. In malesuada nibh orci, eu consectetur velit mollis sit amet. Suspendisse non feugiat sem, ac sodales dui. Quisque ultrices ultrices scelerisque. Nam venenatis fringilla augue ac varius. Suspendisse potenti. Curabitur sagittis euismod erat id tincidunt. Proin sit amet quam nec sem lacinia imperdiet eu at ex. Curabitur ipsum nunc, consectetur sed luctus et, tristique non dolor. Ut varius aliquam rhoncus.  '
            );
        $manager->persist($article);


        // comments
        for ($i = 0; $i < 5; $i++) {
            $comment = new Comment();
            $comment->setUser($user)
                ->setArticle($article)
                ->setDepth(0)
                ->setParent(null)
                ->setText(md5('Lorem ipsum dolor' . $i));

            $manager->persist($comment);
        }
        $manager->flush();
    }
}
