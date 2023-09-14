<?phpnamespace Corals\Foundation\Providers;use Illuminate\Support\Collection;use Illuminate\Support\Facades\DB;use Illuminate\Support\ServiceProvider;abstract class BasePackageServiceProvider extends ServiceProvider{    /**     * @var     */    protected $packageCode;    /**     * @var     */    protected static $modules;    /**     *     */    public final function register(): void    {        if ($this->isModuleActive()) {            $this->registerPackage();        }    }    /**     *     */    public final function boot(): void    {        $this->registerModulesPackages();        if ($this->isModuleActive()) {            $this->bootPackage();        }    }    /**     * @return Collection     */    public function getModules(): Collection    {        if (empty(static::$modules)) {            static::$modules = DB::table('modules')->get();        }        return static::$modules;    }    /**     * @return bool     */    protected function isModuleActive(): bool    {        try {            return !!$this->getModules()                ->where('code', $this->packageCode)                ->where('enabled', true)                ->where('installed', true)                ->first();        } catch (\Exception $exception) {            return false;        }    }    /**     * @return mixed     */    public abstract function bootPackage();    /**     * @return mixed     */    public abstract function registerPackage();    /**     * @return mixed     */    public abstract function registerModulesPackages();}