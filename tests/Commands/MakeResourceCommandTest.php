<?php

namespace Nwidart\Modules\Tests\Commands;

use Nwidart\Modules\Tests\BaseTestCase;

class MakeResourceCommandTest extends BaseTestCase
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $finder;
    /**
     * @var string
     */
    private $modulePath;

    public function setUp()
    {
        parent::setUp();
        $this->modulePath = base_path('modules/Blog');
        $this->finder = $this->app['files'];
        $this->artisan('module:make', ['name' => ['Blog']]);
    }

    public function tearDown()
    {
        $this->finder->deleteDirectory($this->modulePath);
        parent::tearDown();
    }

    /** @test */
    public function it_generates_a_new_form_request_class()
    {
        $this->artisan('module:make-resource', ['name' => 'CreateBlogResource', 'module' => 'Blog']);

        $this->assertTrue(is_file($this->modulePath . '/Http/Resources/CreateBlogResource.php'));
    }

    /** @test */
    public function it_generated_correct_file_with_content()
    {
        $this->artisan('module:make-resource', ['name' => 'CreateBlogResource', 'module' => 'Blog']);

        $file = $this->finder->get($this->modulePath . '/Http/Resources/CreateBlogResource.php');

        $this->assertEquals($this->expectedContent(), $file);
    }

    private function expectedContent()
    {
        return <<<TEXT
<?php

namespace Modules\Blog\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CreateBlogResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray(\$request)
    {
        return parent::toArray(\$request);
    }
}

TEXT;
    }
}
