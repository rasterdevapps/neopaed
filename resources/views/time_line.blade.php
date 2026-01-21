@extends('app')
@section('content')
<style type="text/css">
.timeline {
  position: relative;
  width: 100%;
  max-width: 1140px;
  margin: 0 auto;
  padding: 15px 0;
}

.timeline::after {
  content: '';
  position: absolute;
  width: 2px;
  background: #006E51;
  top: 0;
  bottom: 0;
  left: 50%;
  margin-left: -1px;
}

.time-line-container {
  padding: 15px 30px;
  position: relative;
  background: inherit;
  width: 50%;
  margin-left: 0px !important;
  margin-right: 0px !important;
}

.time-line-container.left {
  left: 0;
}

.time-line-container.right {
  left: 50%;
}

.time-line-container::after {
  content: '';
  position: absolute;
  width: 16px;
  height: 16px;
  top: calc(50% - 8px);
  right: -8px;
  background: #ffffff;
  border: 2px solid #006E51;
  border-radius: 16px;
  z-index: 1;
}

.time-line-container.right::after {
  left: -8px;
}

.time-line-container::before {
  content: '';
  position: absolute;
  width: 50px;
  height: 2px;
  top: calc(50% - 1px);
  right: 8px;
  background: #006E51;
  z-index: 1;
}

.time-line-container.right::before {
  left: 8px;
}

.time-line-container .date {
  position: absolute;
  display: inline-block;
  top: calc(50% - 8px);
  text-align: center;
  font-size: 14px;
  font-weight: bold;
  color: #006E51;
  text-transform: uppercase;
  letter-spacing: 1px;
  z-index: 1;
}
.time-line-container .date sup{
    text-transform: lowercase;
}
.time-line-container.left .date {
  right: -240px;
}

.time-line-container.right .date {
  left: -240px;
}

.time-line-container .icon {
  position: absolute;
  display: inline-block;
  width: 40px;
  height: 40px;
  padding: 9px 0;
  top: calc(50% - 20px);
  background: #F6D155;
  border: 2px solid #006E51;
  border-radius: 40px;
  text-align: center;
  font-size: 18px;
  color: #006E51;
  z-index: 1;
}

.time-line-container.left .icon {
  right: 56px;
}

.time-line-container.right .icon {
  left: 56px;
}

.time-line-container .content {
  padding: 30px 90px 30px 30px;
  background: #FDB2B2;
  position: relative;
  border-radius: 0 500px 500px 0;
}

.time-line-container.right .content {
  padding: 30px 30px 30px 90px;
  border-radius: 500px 0 0 500px;
}

.time-line-container .content h2 {
  margin: 0 0 10px 0;
  font-size: 18px;
  font-weight: normal;
  color: #006E51;
}

.time-line-container .content p {
  margin: 0;
  font-size: 16px;
  line-height: 22px;
  color: #000000;
}

@media (max-width: 767.98px) {
  .timeline::after {
    left: 90px;
  }

  .time-line-container {
    width: 100%;
    padding-left: 120px;
    padding-right: 30px;
    margin-left: 0px !important;
    margin-right: 0px !important;
  }

  .time-line-container.right {
    left: 0%;
  }

  .time-line-container.left::after, 
  .time-line-container.right::after {
    left: 82px;
  }

  .time-line-container.left::before,
  .time-line-container.right::before {
    left: 100px;
    border-color: transparent #006E51 transparent transparent;
  }

  .time-line-container.left .date,
  .time-line-container.right .date {
    right: auto;
    left: 15px;
  }

  .time-line-container.left .icon,
  .time-line-container.right .icon {
    right: auto;
    left: 146px;
  }

  .time-line-container.left .content,
  .time-line-container.right .content {
    padding: 30px 30px 30px 90px;
    border-radius: 500px 0 0 500px;
  }
}
</style>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li class="current">Neonatal Time line</li>                                                
    </ul>
    <a href="{{ url('ward-dashboard') }}" class="close-nav pull-right"><i class="fa fa-times"></i></a>         
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing">
    <div class="timeline">
        <div class="time-line-container left">
            <div class="date">Since Jan 2011 - Aug 2017</div>
            <i class="icon fa fa-user-md"></i>
            <div class="content">
                <h2>Doctor's module</h2>
                <p>Instantly generated NICU and postnatal discharge summaries, OP consultation records and scan reports. Automated plotting of growth charts</p>
            </div>
        </div>
        <div class="time-line-container right">
            <div class="date">Aug 2017 - 26<sup>th</sup> Sep 2022</div>
            <i class="icon fa fa-user-nurse"></i>
            <div class="content">
                <h2>Doctor and Nurse entry module</h2>
                <p>Electronic baby registration, admission records, daily ward round entries, digital entry of neonatal problems and nurses data entry made easy with in built intelligent navigation</p>
            </div>
        </div>
        <div class="time-line-container left">
            <div class="date">27<sup>th</sup> Sep 2022 - till now</div>
            <i class="icon fa fa-pager"></i>
            <div class="content">
                <h2>Integrated Module</h2>
                <p>Automated data capture from monitors, ventilators, syringe pumps and other devices</p>
            </div>
        </div>
    </div>
</div>

@endsection