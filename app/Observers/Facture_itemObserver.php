<?php

namespace App\Observers;

use App\Facture_item;
use App\Facture;

class Facture_itemObserver
{
    /**
     * Listen to the Applicant_history created event.
     *
     * @param  Applicant_history  $applicant_history
     * @return void
     */
    public function created(Facture_item $fac_item)
    {
        $facture_id = $fac_item->facture_id;
		$facture = Facture::find($facture_id);
		$TVA = $facture->TVA;
		$total_price = $fac_item->quantity*$fac_item->unit_price;
		
		$fac_item->total_price = $total_price;
		$fac_item->total_TTC_price = $TVA == 1 ? $total_price*1.2 : $total_price;
		$fac_item->save();
		
		$facture_total_price = Facture_item::where('facture_id',$facture_id)->sum('total_price');
		$facture_total_TTC_price = Facture_item::where('facture_id',$facture_id)->sum('total_TTC_price');
		$facture_total_TVA_price = $facture_total_TTC_price - $facture_total_price;
		
		Facture::where('id', $facture_id)
        ->update([
			'total_price' => $facture_total_price,
			'total_TVA_price' => $facture_total_TVA_price,
			'total_TTC_price' => $facture_total_TTC_price
		]);
		
	}
	
	public function updated (Facture_item $fac_item) {
		$facture_id = $fac_item->facture_id;
				
		$facture = Facture::find($facture_id);
		$TVA = $facture->TVA;
		$total_price = $fac_item->quantity*$fac_item->unit_price;
		
		//$fac_item->total_price = $total_price;
		//$fac_item->total_TTC_price = $TVA == 1 ? $total_price*1.2 : $total_price;
		//$fac_item->save();
		
		Facture_item::where('id', $fac_item->id)
        ->update([
			'total_price' => $total_price,
			'total_TTC_price' => $TVA == 1 ? $total_price*1.2 : $total_price
		]);
		
		$facture_total_price = Facture_item::where('facture_id',$facture_id)->sum('total_price');
		$facture_total_TTC_price = Facture_item::where('facture_id',$facture_id)->sum('total_TTC_price');
		$facture_total_TVA_price = $facture_total_TTC_price - $facture_total_price;
		
		Facture::where('id', $facture_id)
        ->update([
			'total_price' => $facture_total_price,
			'total_TVA_price' => $facture_total_TVA_price,
			'total_TTC_price' => $facture_total_TTC_price
		]);
		
	}
	
	public function deleted (Facture_item $fac_item) {
		$facture_id = $fac_item->facture_id;
		$facture = Facture::find($facture_id);
			
		$facture_total_price = Facture_item::where('facture_id',$facture_id)->sum('total_price');
		$facture_total_TTC_price = Facture_item::where('facture_id',$facture_id)->sum('total_TTC_price');
		$facture_total_TVA_price = $facture_total_TTC_price - $facture_total_price;
		
		Facture::where('id', $facture_id)
        ->update([
			'total_price' => $facture_total_price,
			'total_TVA_price' => $facture_total_TVA_price,
			'total_TTC_price' => $facture_total_TTC_price
		]);
		
	}
}