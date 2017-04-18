<?php

/**
 * Class Helper
 */
trait Helper
{
    /**
     * @return \Illuminate\Database\Schema\Builder
     */
    protected function getSchemeBuilder()
    {
        return app('db')->connection($this->getConnection())
            ->getSchemaBuilder();
    }
    
    /**
     * scheme down
     */
    public function down()
    {
        $this->disableForeignKeyCheck();
        $this->getSchemeBuilder()->drop($this->table);
        $this->enableForeignKeyCheck();
    }
    
    /**
     * @return bool|null
     */
    protected function disableForeignKeyCheck()
    {
        switch (app('db')->getDriverName()) {
            case "sqlite":
                return app('db')->statement('PRAGMA foreign_keys = OFF');
                break;
            case "mysql":
                return app('db')->statement('SET FOREIGN_KEY_CHECKS = 0');
                break;
            case 'sqlsrv':
                return app('db')->statement("ALTER TABLE {$this->table} NOCHECK CONSTRAINT ALL");
                break;
            default:
                return null;
                break;
        }
    }
    
    /**
     * @return bool|null
     */
    protected function enableForeignKeyCheck()
    {
        switch (app('db')->getDriverName()) {
            case "sqlite":
                return app('db')->statement('PRAGMA foreign_keys = ON');
                break;
            case "mysql":
                return app('db')->statement('SET FOREIGN_KEY_CHECKS = 1');
                break;
            case 'sqlsrv':
                return app('db')->statement("ALTER TABLE {$this->table} CHECK CONSTRAINT ALL");
                break;
            default:
                return null;
                break;
        }
    }
}
