<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('categories')->delete();

        $repository = app(\Leroy\Repositories\Interfaces\CategoryRepository::class);
        $repository->skipPresenter(true);

        foreach ($this->getData() as $c){
            $product = $c['products'];
            unset($c['products']);
            $model = $repository->create($c);
                foreach ($product as $p){
                    $model->products()->create($p);
                }
            }
        
    }
    
    private function getData(){
        return [
            ['name'=>'category_1',
                'description'=>'category A para produtos eletricos',
                'products'=>[
                    ['lm'=>1001,'name'=>'produto A','price'=>100.22,'free_shipping'=>1,'description'=>'produto A'],
                    ['lm'=>1002,'name'=>'produto B','price'=>120.22,'free_shipping'=>1,'description'=>'produto B'],
                    ['lm'=>1003,'name'=>'produto C','price'=>50.54,'free_shipping'=>0,'description'=>'produto C'],
                    ['lm'=>1004,'name'=>'produto D','price'=>70.66,'free_shipping'=>0,'description'=>'produto D'],
                    ['lm'=>1005,'name'=>'produto E','price'=>150.50,'free_shipping'=>1,'description'=>'produto E'],
                    ['lm'=>1006,'name'=>'produto F','price'=>1000.33,'free_shipping'=>0,'description'=>'produto F'],
                 ]
            ],
            ['name'=>'category_2',
                'description'=>'category b para produtos hidraulicos',
                'products'=>[
                    ['lm'=>1050,'name'=>'produto A','price'=>12.22,'free_shipping'=>1,'description'=>'produto A'],
                    ['lm'=>1012,'name'=>'produto B','price'=>10.22,'free_shipping'=>1,'description'=>'produto B'],
                    ['lm'=>1303,'name'=>'produto C','price'=>55.54,'free_shipping'=>0,'description'=>'produto C'],
                    ['lm'=>1504,'name'=>'produto D','price'=>75.66,'free_shipping'=>0,'description'=>'produto D'],
                    ['lm'=>1055,'name'=>'produto E','price'=>15.50,'free_shipping'=>1,'description'=>'produto E'],
                    ['lm'=>1506,'name'=>'produto F','price'=>100.33,'free_shipping'=>0,'description'=>'produto F'],
                 ]
            ]
        ];
    }
}
