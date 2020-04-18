<?php

function covid19ImpactEstimator($data)
{
  $reported_cases = $data->reportedCases;
  $total_hospital_beds = $data->totalHospitalBeds;
  $avg_daily_income_population = $data->region->avgDailyIncomePopulation;
  $avg_daily_income_in_usd = $data->region->avgDailyIncomeInUSD;

  $impact['impact']['currentlyInfected'] = $reported_cases * 10;
  $severe_impact['severImpact']['currentlyInfected'] = $reported_cases * 50;

  //projection in 30day (after 3days 2^10)
  $impact['impact']['infectionsByRequestedTime'] = $impact['impact']['currentlyInfected'] * 1024;
  $severe_impact['severImpact']['infectionsByRequestedTime'] = $severe_impact['severImpact']['currentlyInfected'] * 1024;

  $severe_cases = $impact['impact']['infectionsByRequestedTime'] * 0.15;

  //casesForICUByRequestedTime
  $icu_care_cases = $impact['impact']['infectionsByRequestedTime'] * 0.05;

  //casesForVentilatorsByRequestedTime
  $ven_cases = $impact['impact']['infectionsByRequestedTime'] * 0.02;

  //dollarsInFlight
  $dollars_in_flight = ($impact['impact']['infectionsByRequestedTime'] * $avg_daily_income_population) * $avg_daily_income_in_usd * 30;

  $available_hospital_beds = $total_hospital_beds * 0.35;
  $hospital_beds_by_requested_time = $available_hospital_beds - $severe_cases;

  $dd['data']['impact']['currentlyInfected']= $impact['impact']['currentlyInfected'];
  $dd['data']['impact']['infectionsByRequestedTime'] = $impact['impact']['infectionsByRequestedTime'];
  $dd['data']['severImpact']['currentlyInfected'] = $severe_impact['severImpact']['currentlyInfected'];
  $dd['data']['severImpact']['infectionsByRequestedTime'] = $severe_impact['severImpact']['infectionsByRequestedTime'];
  $dd['data']['hospitalBedsByRequestedTime'] = $hospital_beds_by_requested_time;
  $dd['data']['severeCasesByRequestedTime'] = $severe_cases;
  $dd['data']['casesForICUByRequestedTime'] = $icu_care_cases;
  $dd['data']['casesForVentilatorsByRequestedTime'] = $ven_cases;
  $dd['data']['dollarsInFlight'] = $dollars_in_flight;
  return $dd;
}
