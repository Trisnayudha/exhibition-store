<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CompanyService extends Model
{
    public static function detailForm($id)
    {
        return DB::table('company')
            ->select(
                'company.id',
                'company.created_at',
                'company.type',

                'company.ms_prefix_call_id',
                'ms_prefix_call.name as call_name',

                'company.ms_company_type_id',
                'ms_company_type.name as company_type',

                'company.ms_phone_code_id',
                'ms_phone_code.code as phone_code',

                'company.ms_country_id',
                'ms_country.name as country_name',

                'company.ms_state_id',
                'ms_state.name as state_name',

                'company.ms_city_id',
                'ms_city.name as city_name',

                'company.ms_company_category_id',
                'ms_company_category.name as company_category_name',
                'company.ms_company_category_other as company_category_other',

                'company.name_pic',
                'company.name',
                'company.slug',
                'company.image',
                'company.image_cropping',
                'company.job_title',
                'company.email',
                'company.email_alternate',
                'company.website',
                'company.phone',
                'company.location',
                'company.branch_office',
                'company.info_one',
                'company.info_two',
                'company.info_three',
                'company.time_close',
                'company.time_open',
                'company.desc',
                'company.post_code',
                'company.company_address',
                'company.with_information',
                'company.facebook',
                'company.twitter',
                'company.linkedin',
                'company.whatsapp',
                'company.instagram',
                'company.company_name',
                // 'company.website as company_web',
                'company.country',
                'company.state',
                'company.city',
                'company.company_web as company_web',
                'company.company_phone',
                'company.ms_company_class_id',
                'company.nonresidence',
                'company.answerresidence',
                'company.pic_name',
                'company.pic_job_title',
                'company.pic_phone',
                'company.pic_email',
                'company.fascia_name',
                'company.pic_signature',
                'company.exhibition_design',
                'company.npwp',
                'company.booth',
                'company.inclusion',
                'company.deadline',
                'company.level',

                'company.ms_class_company_minerals_id',
                'ms_class_company_minerals.name as classify_minerals_name',
                'company.class_company_minerals_other as classify_minerals_other',

                'company.ms_class_company_mining_id',
                'ms_class_company_mining.name as classify_mining_name',
                'company.class_company_mining_other as classify_mining_other',

                'company.ms_commod_company_minerals_id',
                'ms_commod_company_minerals.name as commodities_minerals_name',
                'company.commod_company_minerals_other as commodities_minerals_other',

                'company.ms_commod_company_minerals_coal_id',
                'ms_commod_company_minerals_coal.name as commodities_minerals_coal_name',
                'company.commod_company_minerals_coal_other as commodities_minerals_coal_other',

                'company.ms_commod_company_mining_id',
                'ms_commod_company_mining.name as commodities_mining_name',
                'company.commod_company_mining_other as commodities_mining_other',

                'company.ms_origin_manufactur_company_id',
                'ms_origin_manufactur_company.name as origin_manufacturer_name',
                'company.origin_manufactur_company_other as origin_manufacturer_other',

                'company.ms_company_project_type_id',
                'ms_company_project_type.name as project_type'
            )
            ->leftJoin('ms_prefix_call', function ($join) {
                $join->on('ms_prefix_call.id', '=', 'company.ms_prefix_call_id');
            })
            ->leftJoin('ms_company_type', function ($join) {
                $join->on('ms_company_type.id', '=', 'company.ms_company_type_id');
            })
            ->leftJoin('ms_phone_code', function ($join) {
                $join->on('ms_phone_code.id', '=', 'company.ms_phone_code_id');
            })
            ->leftJoin('ms_country', function ($join) {
                $join->on('ms_country.id', '=', 'company.ms_country_id');
            })
            ->leftJoin('ms_state', function ($join) {
                $join->on('ms_state.id', '=', 'company.ms_state_id');
            })
            ->leftJoin('ms_city', function ($join) {
                $join->on('ms_city.id', '=', 'company.ms_city_id');
            })
            ->leftJoin('ms_company_category', function ($join) {
                $join->on('ms_company_category.id', '=', 'company.ms_company_category_id');
            })
            ->leftJoin('ms_class_company_minerals', function ($join) {
                $join->on('ms_class_company_minerals.id', '=', 'company.ms_class_company_minerals_id');
            })
            ->leftJoin('ms_class_company_mining', function ($join) {
                $join->on('ms_class_company_mining.id', '=', 'company.ms_class_company_mining_id');
            })
            ->leftJoin('ms_commod_company_minerals', function ($join) {
                $join->on('ms_commod_company_minerals.id', '=', 'company.ms_commod_company_minerals_id');
            })
            ->leftJoin('ms_commod_company_minerals_coal', function ($join) {
                $join->on('ms_commod_company_minerals_coal.id', '=', 'company.ms_commod_company_minerals_coal_id');
            })
            ->leftJoin('ms_commod_company_mining', function ($join) {
                $join->on('ms_commod_company_mining.id', '=', 'company.ms_commod_company_mining_id');
            })
            ->leftJoin('ms_origin_manufactur_company', function ($join) {
                $join->on('ms_origin_manufactur_company.id', '=', 'company.ms_origin_manufactur_company_id');
            })
            ->leftJoin('ms_company_project_type', function ($join) {
                $join->on('ms_company_project_type.id', '=', 'company.ms_company_project_type_id');
            })
            ->where(function ($q) use ($id) {
                if (!empty($id)) {
                    $q->where('company.id', $id);
                }
            })
            ->first();
    }

    public static function detailVideo($id)
    {
        return DB::table('company_video')
            ->where('company_id', $id)
            ->get();
    }
}
