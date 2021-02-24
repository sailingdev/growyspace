<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

use App\Mark; 
use App\Mark_model; 
use App\Mark_model_motorization; 
use App\Mark_model_motorization_power; 
use App\Product; 
use App\Product_group; 
use App\Product_group_item; 
use App\Product_group_images; 

class DashboardController extends Controller
{
	public $product_data = [];
	public $hrefs = [];
	public $ids = [];
	
	public $prod_ref = [];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		echo 'Index';
	}
	
	 /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function parse()
    {
		/*$client = new Client();
		$crawler = $client->request('GET', 'http://auto-turbo.fr/cars.html');
		$hrefs = [];
		$crawler->filter('._2-MzW')->each(function ($node) use($client)  {
			$href = $node->attr('href');
			
			if(strpos($href,'voitures') !== false) {
				
				$this->hrefs[] = 'https://www.leboncoin.fr'.$href;	
			}
			
		});*/
		
		
	
				$client = new Client();				
				$crawler2 = $client->request('GET', 'https://www.leboncoin.fr/voitures/1788507285.htm');
				
				if(count($crawler2->filter('title')) > 0) {
					echo $crawler2->filter('title')->text().'<br/> ';
				}
		
		
		
		
		
		
		
		
		echo '55555555555555555555555555555555555';exit;
		/*$products = Product::where('description','like','%st-turbo.com%')->get();
		
		foreach($products as $k => &$v) {
			$new_desc = '';
			foreach(preg_split("/((\r?\n)|(\r\n?))/", $v->description) as $index => $line){
				
				if(trim($line) !='') {
					$pos = strpos($line,'ST-TURBO.com');
					
					if($pos !== false) {
						$v->description = $new_desc;
						$p = Product::find($v->id);
						$p->description = $new_desc.'<br>Le prix affiché est TTC.';
						$p->save();
					}
				}
				$new_desc .= $line;
			} 
						
			
		}
		
		echo 4444444444444;exit;*/
		/*$x = Product_group_images::all();
		foreach($x as $v) {
			$z = Product_group::find($v->id);
			$z->name = 'Group '.$v->id;
			$z->save();
		}
		echo 'Parse';exit;
		echo 'ooooo';exit;*/
		//for($i = 1;$i <= 39;$i++) {
			$client = new Client();
			$crawler = $client->request('GET', 'https://www.st-turbo.com/trouver-mon-turbo.htm?page=39');
				
			$crawler->filter('.list_content')->each(function ($node) use($client)  {
				$href = $node->filter('a:first-child')->attr('href');
				$img_src = $node->filter('a:first-child')->filter('img')->attr('src');
								
				$tmp = strpos($img_src,'product_');
				$product_id = substr($img_src,$tmp + 8,8);
				$this->product_data[$product_id] = [];
				$this->product_data[$product_id]['reference'] = [];
									
				$crawler2 = $client->request('GET', $href);
				
				$title = $crawler2->filter('#product')->filter('h1')->text();
				$this->product_data[$product_id]['title'] = $title;
				
				$title2 = $crawler2->filter('#product')->filter('h2')->text();
				$this->product_data[$product_id]['title2'] = $title2;
								
				if(0 ==  count($crawler2->filter('#contentTab4')->filter('ul')->filter('li'))) {
					$ref_item = $crawler2->filter('#contentTab4')->text();
					$this->product_data[$product_id]['reference'][] = $ref_item;
				}
							
				$crawler2->filter('#contentTab4')->filter('ul')->filter('li')->each(function ($node2) use($product_id,$crawler2) {
					$ref_item = $node2->text();
					$this->product_data[$product_id]['reference'][] = $ref_item;
				});
				
				$crawler2->filter('link[itemprop=image]')->each(function ($node3) use($product_id) {
					$img_item = $node3->attr('href');
					$this->product_data[$product_id]['img_src'][] = $img_item;
				});
				
				$category = $crawler2->filter('.pdtlibshortdiv')->filter('.pdtlibshortspan')->text();
				$this->product_data[$product_id]['category'] = $category;
				
				$price = $crawler2->filter('.price_TTC')->filter('.price_value')->text();
				
				if (0 ==  count($crawler2->filter('#item1')->filter('.price'))){
					$price2 = 0;
				} else {
					$price2 = $crawler2->filter('#item1')->filter('.price')->text();
				}
				
								
				$this->product_data[$product_id]['price'] = $price;
				$this->product_data[$product_id]['price2'] = $price2;
							
				$full_description = $crawler2->filter('#contener_content')->filter('.content-active')->html();
				$this->product_data[$product_id]['full_description'] = $full_description;
				
				$model_string = $crawler2->filter('#contentTab3')->text();
				$model_string_array_ = explode(PHP_EOL, $model_string);
							
				foreach($model_string_array_ as $k => $v) {
					$string = html_entity_decode($v);
					$string = preg_replace("/\s/",'',$string);
					$string = htmlentities($string);
									
					if (trim($string) == '' || trim($string) == '&nbsp;') {
						unset($model_string_array_[$k]);
					}
				}
										
				$this->product_data[$product_id]['model_string'] = $model_string;
				$this->product_data[$product_id]['model_string_array'] = array_values($model_string_array_);
			});
		
			//echo '<pre>';
			//print_r($this->product_data);exit;
			
			foreach($this->product_data as $san_data_id => $data) {
				$references = $data['reference'];
				
				$full_description = $data['full_description'];
				$category = trim(str_replace("Catégorie :","", $data['category']));
				
				if ($category == 'Turbo') {
					$category_id = 1;
				} else {
					$category_id = 2;
				}
				
				$title = $data['title'];
				$title2 = $data['title2'];
				$img_src = $data['img_src'];
				$price = $data['price'];
				$price2 = $data['price2'];
				
				//$detect_group = $this->detect_group($references,$price,$price2);
				$detect_group = 999;
				$group_id = $detect_group[0];
				$need_to_add_images = $detect_group[1];
				$photos_path = base_path() . '/public/uploads/product_group_images/'.$group_id;
				
				/*if (!is_dir($photos_path)) {
					mkdir($photos_path, 0777,true);
				}
				
				if($need_to_add_images) {
					if(count($img_src) > 0) {
						foreach($img_src as $index => $img_link) {
							
							$img_name = 'Group '.$group_id.'_'.($index + 1);
							
							if ( copy($img_link, $photos_path.'/'.$img_name.'.jpg') ) {
								
							}else{
								
							}
							
							$pgi = new Product_group_images;
							$pgi->group_id = $group_id;
							$pgi->image_url = $img_name;
							$pgi->save();
							
						}					
					}
				}*/
							
				$model_string_array = $data['model_string_array'];
				
				if($san_data_id == '10553802') {
					$tmp = ['Volkswagen','Transporter T5','2.5 TDI','130 CV'];
				} else {
					if (isset($model_string_array[0])) {
						$tmp = explode("/",$model_string_array[0]);
					} else {
						$tmp = ['No Mark','No Model','No motorization','No power'];
					}
				}
				
				if(count((array)$tmp) == 5) {
					$tmp[3] = $tmp[3].'/'.$tmp[4];
					unset($tmp[4]);
				}
				
				
				if(count((array)$tmp) != 4) {
					$tmp = ['No Mark','No Model','No motorization','No power'];
				} 
				
				if(count((array)$tmp) == 4) {
					$mark         = trim($tmp[0]);
					if($mark == 'AUDI') {
						$mark = 'Audi';
					} else if($mark == 'Land-Rover') {
						$mark = 'Land Rover';
					}
						
					$mark = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $mark);
		
					$model = trim($tmp[1]);
					$model = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $model);
					
					if($model == 'RAF4') {
						$model = 'RAV 4';
					}

					
					$motorization = strtoupper(trim($tmp[2]));
					$motorization = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $motorization);
										
					$power = strtoupper(trim($tmp[3]));
					$power = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $power);
					
					
					$mark_row = Mark::where('name', $mark)->first();
					
					if (count((array)$mark_row) > 0) {
						$mark_id = $mark_row->id;
					} else {
						$mark_row = new Mark;
						$mark_row->name = $mark;
						$mark_row->save();
						$mark_id = $mark_row->id;
					}
					
					$model_row = Mark_model::where('name', $model)->where('mark_id',$mark_id)->first();
					
					if (count((array)$model_row) > 0) {
						$model_id = $model_row->id;
					} else {
						$model_row = new Mark_model;
						$model_row->name = $model;
						$model_row->mark_id = $mark_id;
						$model_row->save();
						$model_id = $model_row->id;
					}
					
					$motorization_row = Mark_model_motorization::where('name', $motorization)->where('model_id',$model_id)->first();
					
					if (count((array)$motorization_row) > 0) {
						 $motorization_id = $motorization_row->id;
					} else {
						$motorization_row = new Mark_model_motorization;
						$motorization_row->name = $motorization;
						$motorization_row->model_id = $model_id;
						$motorization_row->save();
						$motorization_id = $motorization_row->id;
					}
					
					$power_row = Mark_model_motorization_power::where('name', $power)->where('motorization_id',$motorization_id)->first();
					
					if (count((array)$power_row) > 0) {
						 $power_id = $power_row->id;
					} else {
						$power_row = new Mark_model_motorization_power;
						$power_row->name = $power;
						$power_row->motorization_id = $motorization_id;
						$power_row->save();
						$power_id = $power_row->id;
					}
					
				} else {
					var_dump($san_data_id);exit;
				}
				
							
				$p = Product::where('san_data_id',$san_data_id)->first();
				
				if($mark_id != '12') {
					//$p->title = $title;
					//$p->title2 = $title2;
					//$p->description = $full_description;
					//$p->san_data_id = $san_data_id;
					$p->mark_id = $mark_id;
					$p->model_id = $model_id;
					$p->motorization_id = $motorization_id;
					$p->power_id = $power_id;
					//$p->group_id = $group_id;
					//$p->category_id = $category_id;
					$p->save();
				}
				
			}
				
			echo ' 1000';;
		//}
		
		exit;
	}

	public function detect_group($references,$price,$price2) {
		$first_item = $references[0];
		$price2 = (float)str_replace('€ T.T.C.','',$price2);
				
		$item = Product_group_item::where('name',$first_item)->first();
		
		if (count((array)$item) == 0) {
			$pg = new Product_group; 
			$pg->name = 'Group '.rand();
			$pg->price = $price;
			$pg->price2 = $price2;
			$pg->save();
			$group_id = $pg->id;
			foreach($references as $v) {
				$pg_item = new Product_group_item;
				$pg_item->group_id = $group_id;
				$pg_item->name = $v;
				$pg_item->save();
			}
			$need_to_add_images = true;
		} else {
			$group_id = $item->group_id;
			$need_to_add_images = false;
		}
		
		return [$group_id,$need_to_add_images];
	}
}