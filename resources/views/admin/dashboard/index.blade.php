@extends('layout')

@section('pagetitle', 'Dashboard')

@section('content')
<div class="row no-gutters">
    <div class="col-md-6 col-xxl-3 mb-3 pr-md-2">
      <div class="card h-md-100">
        <div class="card-header pb-0">
          <h6 class="mb-0 mt-2 d-flex align-items-center">Weekly Sales<span class="ml-1 text-400" data-toggle="tooltip" data-placement="top" title="Calculated according to last week's sales"><span class="far fa-question-circle" data-fa-transform="shrink-1"></span></span>
          </h6>
        </div>
        <div class="card-body d-flex align-items-end">
          <div class="row flex-grow-1">
            <div class="col">
              <div class="fs-4 font-weight-normal text-sans-serif text-700 line-height-1 mb-1">$47K</div><span class="badge badge-pill fs--2 badge-soft-success">+3.5%</span>
            </div>
            <div class="col-auto pl-0">
              <div class="echart-bar-weekly-sales h-100"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xxl-3 mb-3 pl-md-2 pr-xxl-2">
      <div class="card h-md-100">
        <div class="card-header pb-0">
          <h6 class="mb-0 mt-2">Total Order</h6>
        </div>
        <div class="card-body pt-0">
          <div class="row h-100">
            <div class="col align-self-end">
              <div class="fs-4 font-weight-normal text-sans-serif text-700 line-height-1 mb-1">58.4K</div><span class="badge badge-pill fs--2 bg-200 text-primary"><span class="fas fa-caret-up mr-1"></span>13.6%</span>
            </div>
            <div class="col-auto pl-0">
              <div class="echart-line-total-order h-100"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xxl-3 mb-3 pr-md-2 pl-xxl-2">
      <div class="card h-md-100">
        <div class="card-body">
          <div class="row h-100 justify-content-between no-gutters">
            <div class="col-5 col-sm-6 col-xxl pr-2">
              <h6 class="mt-1">Market Share</h6>
              <div class="fs--2 mt-3">
                <div class="d-flex flex-between-center mb-1">
                  <div class="d-flex align-items-center"><span class="dot bg-primary"></span><span class="font-weight-semi-bold">Samsung</span></div>
                  <div class="d-xxl-none">33%</div>
                </div>
                <div class="d-flex flex-between-center mb-1">
                  <div class="d-flex align-items-center"><span class="dot bg-info"></span><span class="font-weight-semi-bold">Huawei</span></div>
                  <div class="d-xxl-none"> 29%</div>
                </div>
                <div class="d-flex flex-between-center mb-1">
                  <div class="d-flex align-items-center"><span class="dot bg-300"></span><span class="font-weight-semi-bold">Apple</span></div>
                  <div class="d-xxl-none"> 20%</div>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <div class="echart-doughnut"></div>
              <div class="absolute-centered font-weight-medium text-dark fs-2">26M</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-xxl-3 mb-3 pl-md-2">
      <div class="card h-md-100">
        <div class="card-header d-flex flex-between-center pb-0">
          <h6 class="mb-0">Weather</h6>
          <div class="dropdown text-sans-serif btn-reveal-trigger">
            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none" type="button" id="dropdown-weather-update" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
            <div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="dropdown-weather-update">
              <div class="bg-white py-2"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body pt-2">
          <div class="row no-gutters h-100 align-items-center">
            <div class="col">
              <div class="media align-items-center"><img class="mr-3" src="{{ Theme::url('img/icons/weather-icon.png') }}" alt="" height="60" />
                <div class="media-body">
                  <h6 class="mb-2">New York City</h6>
                  <div class="fs--2 font-weight-semi-bold">
                    <div class="text-warning">Sunny</div>Precipitation: 50%
                  </div>
                </div>
              </div>
            </div>
            <div class="col-auto text-center pl-2">
              <div class="fs-4 font-weight-normal text-sans-serif text-primary mb-1 line-height-1">31&deg;</div>
              <div class="fs--1 text-800">32&deg; / 25&deg;</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row no-gutters">
    <div class="col-lg-6 pr-lg-2 mb-3">
      <div class="card h-lg-100 overflow-hidden">
        <div class="card-header bg-light">
          <div class="row align-items-center">
            <div class="col">
              <h6 class="mb-0">Running Projects</h6>
            </div>
            <div class="col-auto text-center pr-card">
              <select class="custom-select custom-select-sm">
                <option>Working Time</option>
                <option>Estimated Time</option>
                <option>Billable Time</option>
              </select>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="row no-gutters align-items-center py-2 position-relative border-bottom border-200">
            <div class="col pl-card py-1 position-static">
              <div class="media align-items-center">
                <div class="avatar avatar-xl mr-3">
                  <div class="avatar-name rounded-circle bg-soft-primary text-dark"><span class="fs-0 text-primary">F</span></div>
                </div>
                <div class="media-body">
                  <h6 class="mb-0 d-flex align-items-center"><a class="text-800 stretched-link" href="#!">Falcon</a><span class="badge badge-pill ml-2 bg-200 text-primary">38%</span></h6>
                </div>
              </div>
            </div>
            <div class="col py-1">
              <div class="row flex-end-center no-gutters">
                <div class="col-auto pr-2">
                  <div class="fs--1 font-weight-semi-bold">12:50:00</div>
                </div>
                <div class="col-5 pr-card pl-2">
                  <div class="progress mr-2" style="height: 5px;">
                    <div class="progress-bar rounded-capsule" role="progressbar" style="width: 38%" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row no-gutters align-items-center py-2 position-relative border-bottom border-200">
            <div class="col pl-card py-1 position-static">
              <div class="media align-items-center">
                <div class="avatar avatar-xl mr-3">
                  <div class="avatar-name rounded-circle bg-soft-success text-dark"><span class="fs-0 text-success">R</span></div>
                </div>
                <div class="media-body">
                  <h6 class="mb-0 d-flex align-items-center"><a class="text-800 stretched-link" href="#!">Reign</a><span class="badge badge-pill ml-2 bg-200 text-primary">79%</span></h6>
                </div>
              </div>
            </div>
            <div class="col py-1">
              <div class="row flex-end-center no-gutters">
                <div class="col-auto pr-2">
                  <div class="fs--1 font-weight-semi-bold">25:20:00</div>
                </div>
                <div class="col-5 pr-card pl-2">
                  <div class="progress mr-2" style="height: 5px;">
                    <div class="progress-bar rounded-capsule" role="progressbar" style="width: 79%" aria-valuenow="79" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row no-gutters align-items-center py-2 position-relative border-bottom border-200">
            <div class="col pl-card py-1 position-static">
              <div class="media align-items-center">
                <div class="avatar avatar-xl mr-3">
                  <div class="avatar-name rounded-circle bg-soft-info text-dark"><span class="fs-0 text-info">B</span></div>
                </div>
                <div class="media-body">
                  <h6 class="mb-0 d-flex align-items-center"><a class="text-800 stretched-link" href="#!">Boots4</a><span class="badge badge-pill ml-2 bg-200 text-primary">90%</span></h6>
                </div>
              </div>
            </div>
            <div class="col py-1">
              <div class="row flex-end-center no-gutters">
                <div class="col-auto pr-2">
                  <div class="fs--1 font-weight-semi-bold">58:20:00</div>
                </div>
                <div class="col-5 pr-card pl-2">
                  <div class="progress mr-2" style="height: 5px;">
                    <div class="progress-bar rounded-capsule" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row no-gutters align-items-center py-2 position-relative border-bottom border-200">
            <div class="col pl-card py-1 position-static">
              <div class="media align-items-center">
                <div class="avatar avatar-xl mr-3">
                  <div class="avatar-name rounded-circle bg-soft-warning text-dark"><span class="fs-0 text-warning">R</span></div>
                </div>
                <div class="media-body">
                  <h6 class="mb-0 d-flex align-items-center"><a class="text-800 stretched-link" href="#!">Raven</a><span class="badge badge-pill ml-2 bg-200 text-primary">40%</span></h6>
                </div>
              </div>
            </div>
            <div class="col py-1">
              <div class="row flex-end-center no-gutters">
                <div class="col-auto pr-2">
                  <div class="fs--1 font-weight-semi-bold">21:20:00</div>
                </div>
                <div class="col-5 pr-card pl-2">
                  <div class="progress mr-2" style="height: 5px;">
                    <div class="progress-bar rounded-capsule" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row no-gutters align-items-center py-2 position-relative">
            <div class="col pl-card py-1 position-static">
              <div class="media align-items-center">
                <div class="avatar avatar-xl mr-3">
                  <div class="avatar-name rounded-circle bg-soft-danger text-dark"><span class="fs-0 text-danger">S</span></div>
                </div>
                <div class="media-body">
                  <h6 class="mb-0 d-flex align-items-center"><a class="text-800 stretched-link" href="#!">Slick</a><span class="badge badge-pill ml-2 bg-200 text-primary">70%</span></h6>
                </div>
              </div>
            </div>
            <div class="col py-1">
              <div class="row flex-end-center no-gutters">
                <div class="col-auto pr-2">
                  <div class="fs--1 font-weight-semi-bold">31:20:00</div>
                </div>
                <div class="col-5 pr-card pl-2">
                  <div class="progress mr-2" style="height: 5px;">
                    <div class="progress-bar rounded-capsule" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer bg-light p-0"><a class="btn btn-sm btn-link btn-block py-2" href="#!">Show all projects<span class="fas fa-chevron-right ml-1 fs--2"></span></a></div>
      </div>
    </div>
    <div class="col-lg-6 pl-lg-2 mb-3">
      <div class="card h-lg-100">
        <div class="card-header">
          <div class="row flex-between-center">
            <div class="col-auto">
              <h6 class="mb-0">Total Sales</h6>
            </div>
            <div class="col-auto d-flex">
              <select class="custom-select custom-select-sm select-month mr-2">
                <option value="0">January</option>
                <option value="1">February</option>
                <option value="2">March</option>
                <option value="3">April</option>
                <option value="4">May</option>
                <option value="5">Jun</option>
                <option value="6">July</option>
                <option value="7">August</option>
                <option value="8">September</option>
                <option value="9">October</option>
                <option value="10">November</option>
                <option value="11">December</option>
              </select>
              <div class="dropdown text-sans-serif btn-reveal-trigger">
                <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none" type="button" id="dropdown-total-saldes" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
                <div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="dropdown-total-saldes">
                  <div class="bg-white py-2"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body h-100 pr-0">
          <div class="echart-line-total-sales h-100" data-echart-responsive="true"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="row no-gutters">
    <div class="col-lg-6 col-xl-7 col-xxl-8 mb-3 pr-lg-2 mb-3">
      <div class="card h-lg-100">
        <div class="card-body d-flex align-items-center">
          <div class="w-100">
            <h6 class="mb-3 text-800">Using Storage <strong class="text-dark">1775.06 MB </strong>of 2 GB</h6>
            <div class="progress mb-3 rounded-soft" style="height: 10px;">
              <div class="progress-bar bg-card-gradient border-right border-white border-2x" role="progressbar" style="width: 43.72%" aria-valuenow="43.72" aria-valuemin="0" aria-valuemax="100"></div>
              <div class="progress-bar bg-info border-right border-white border-2x" role="progressbar" style="width: 18.76%" aria-valuenow="18.76" aria-valuemin="0" aria-valuemax="100"></div>
              <div class="progress-bar bg-success border-right border-white border-2x" role="progressbar" style="width: 9.38%" aria-valuenow="9.38" aria-valuemin="0" aria-valuemax="100"></div>
              <div class="progress-bar bg-200" role="progressbar" style="width: 28.14%" aria-valuenow="28.14" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="row fs--1 font-weight-semi-bold text-500">
              <div class="col-auto d-flex align-items-center pr-2"><span class="dot bg-primary"></span><span>Regular</span><span class="d-none d-md-inline-block d-lg-none d-xxl-inline-block ml-1">(895MB)</span></div>
              <div class="col-auto d-flex align-items-center px-2"><span class="dot bg-info"></span><span>System</span><span class="d-none d-md-inline-block d-lg-none d-xxl-inline-block ml-1">(379MB)</span></div>
              <div class="col-auto d-flex align-items-center px-2"><span class="dot bg-success"></span><span>Shared</span><span class="d-none d-md-inline-block d-lg-none d-xxl-inline-block ml-1">(192MB)</span></div>
              <div class="col-auto d-flex align-items-center pl-2"><span class="dot bg-200"></span><span>Free</span><span class="d-none d-md-inline-block d-lg-none d-xxl-inline-block ml-1">(576MB)</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-xl-5 col-xxl-4 mb-3 pl-lg-2">
      <div class="card h-lg-100">
        <div class="bg-holder bg-card" style="background-image:url(../assets/img/illustrations/corner-1.png);">
        </div>
        <!--/.bg-holder-->

        <div class="card-body position-relative">
          <h5 class="text-warning">Running out of your space?</h5>
          <p class="fs--1 mb-0">Your storage will be running out soon. Get more<br /> space and powerful productivity features.</p><a class="btn btn-link fs--1 text-warning mt-4 mt-lg-3 pl-0" href="#!">Upgrade storage<span class="fas fa-chevron-right ml-1" data-fa-transform="shrink-4 down-1"></span></a>
        </div>
      </div>
    </div>
  </div>
  <div class="row no-gutters">
    <div class="col-lg-7 col-xl-8 pr-lg-2 mb-3">
      <div class="card h-lg-100 overflow-hidden">
        <div class="card-body p-0">
          <table class="table table-dashboard mb-0 table-borderless fs--1">
            <thead class="bg-light">
              <tr class="text-900">
                <th>Best Selling Products</th>
                <th class="text-right">Revenue ($3189)</th>
                <th class="pr-card text-right" style="width: 8rem">Revenue (%)</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-bottom border-200">
                <td>
                  <div class="media align-items-center position-relative"><img class="rounded border border-200" src="../assets/img/products/12.png" width="60" alt="" />
                    <div class="media-body ml-3">
                      <h6 class="mb-1 font-weight-semi-bold"><a class="text-dark stretched-link" href="#!">Raven Pro</a></h6>
                      <p class="font-weight-semi-bold mb-0 text-500">Landing</p>
                    </div>
                  </div>
                </td>
                <td class="align-middle text-right font-weight-semi-bold">$1311</td>
                <td class="align-middle pr-card">
                  <div class="d-flex align-items-center">
                    <div class="progress w-100 mr-2 rounded-soft bg-200" style="height: 5px;">
                      <div class="progress-bar rounded-capsule" role="progressbar" style="width: 41%;" aria-valuenow="41" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="font-weight-semi-bold ml-2">41%</div>
                  </div>
                </td>
              </tr>
              <tr class="border-bottom border-200">
                <td>
                  <div class="media align-items-center position-relative"><img class="rounded border border-200" src="../assets/img/products/10.png" width="60" alt="" />
                    <div class="media-body ml-3">
                      <h6 class="mb-1 font-weight-semi-bold"><a class="text-dark stretched-link" href="#!">Boots4</a></h6>
                      <p class="font-weight-semi-bold mb-0 text-500">Portfolio</p>
                    </div>
                  </div>
                </td>
                <td class="align-middle text-right font-weight-semi-bold">$860</td>
                <td class="align-middle pr-card">
                  <div class="d-flex align-items-center">
                    <div class="progress w-100 mr-2 rounded-soft bg-200" style="height: 5px;">
                      <div class="progress-bar rounded-capsule" role="progressbar" style="width: 27%;" aria-valuenow="27" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="font-weight-semi-bold ml-2">27%</div>
                  </div>
                </td>
              </tr>
              <tr class="border-bottom border-200">
                <td>
                  <div class="media align-items-center position-relative"><img class="rounded border border-200" src="../assets/img/products/11.png" width="60" alt="" />
                    <div class="media-body ml-3">
                      <h6 class="mb-1 font-weight-semi-bold"><a class="text-dark stretched-link" href="#!">Falcon</a></h6>
                      <p class="font-weight-semi-bold mb-0 text-500">Admin</p>
                    </div>
                  </div>
                </td>
                <td class="align-middle text-right font-weight-semi-bold">$539</td>
                <td class="align-middle pr-card">
                  <div class="d-flex align-items-center">
                    <div class="progress w-100 mr-2 rounded-soft bg-200" style="height: 5px;">
                      <div class="progress-bar rounded-capsule" role="progressbar" style="width: 17%;" aria-valuenow="17" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="font-weight-semi-bold ml-2">17%</div>
                  </div>
                </td>
              </tr>
              <tr class="border-bottom border-200">
                <td>
                  <div class="media align-items-center position-relative"><img class="rounded border border-200" src="../assets/img/products/14.png" width="60" alt="" />
                    <div class="media-body ml-3">
                      <h6 class="mb-1 font-weight-semi-bold"><a class="text-dark stretched-link" href="#!">Slick</a></h6>
                      <p class="font-weight-semi-bold mb-0 text-500">Builder</p>
                    </div>
                  </div>
                </td>
                <td class="align-middle text-right font-weight-semi-bold">$245</td>
                <td class="align-middle pr-card">
                  <div class="d-flex align-items-center">
                    <div class="progress w-100 mr-2 rounded-soft bg-200" style="height: 5px;">
                      <div class="progress-bar rounded-capsule" role="progressbar" style="width: 8%;" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="font-weight-semi-bold ml-2">8%</div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="media align-items-center position-relative"><img class="rounded border border-200" src="../assets/img/products/13.png" width="60" alt="" />
                    <div class="media-body ml-3">
                      <h6 class="mb-1 font-weight-semi-bold"><a class="text-dark stretched-link" href="#!">Reign Pro</a></h6>
                      <p class="font-weight-semi-bold mb-0 text-500">Agency</p>
                    </div>
                  </div>
                </td>
                <td class="align-middle text-right font-weight-semi-bold">$234</td>
                <td class="align-middle pr-card">
                  <div class="d-flex align-items-center">
                    <div class="progress w-100 mr-2 rounded-soft bg-200" style="height: 5px;">
                      <div class="progress-bar rounded-capsule" role="progressbar" style="width: 7%;" aria-valuenow="7" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="font-weight-semi-bold ml-2">7%</div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="card-footer bg-light py-2">
          <div class="row flex-between-center">
            <div class="col-auto">
              <select class="custom-select custom-select-sm">
                <option>Last 7 days</option>
                <option>Last Month</option>
                <option>Last Year</option>
              </select>
            </div>
            <div class="col-auto"><a class="btn btn-sm btn-falcon-default" href="#!">View All</a></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-5 col-xl-4 pl-lg-2 mb-3">
      <div class="card h-lg-100">
        <div class="card-header d-flex flex-between-center bg-light py-2">
          <h6 class="mb-0">Shared Files</h6><a class="btn btn-sm btn-link pr-0 fs--1" href="#!">View All</a>
        </div>
        <div class="card-body pb-0">
          <div class="media mb-3 hover-actions-trigger align-items-center">
            <div class="file-thumbnail"><img class="border h-100 w-100 fit-cover rounded-soft" src="../assets/img/products/5-thumb.png" alt="" />
            </div>
            <div class="media-body ml-3">
              <h6 class="mb-1"><a class="stretched-link text-900 font-weight-semi-bold" href="#!">apple-smart-watch.png</a></h6>
              <div class="fs--1"><span class="font-weight-semi-bold">Antony</span><span class="font-weight-medium text-600 ml-2">Just Now</span></div>
              <div class="hover-actions r-0 absolute-vertical-center"><a class="btn btn-light border-300 btn-sm mr-1 text-600 bg-white" data-toggle="tooltip" data-placement="top" title="Download" href="../assets/img/icons/cloud-download.svg" download="download"><img src="../assets/img/icons/cloud-download.svg" alt="" width="15" /></a>
                <button class="btn btn-light border-300 btn-sm mr-1 text-600 bg-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><img src="../assets/img/icons/edit-alt.svg" alt="" width="15" /></button>
              </div>
            </div>
          </div>
          <hr class="border-200" />
          <div class="media mb-3 hover-actions-trigger align-items-center">
            <div class="file-thumbnail"><img class="border h-100 w-100 fit-cover rounded-soft" src="../assets/img/products/3-thumb.png" alt="" />
            </div>
            <div class="media-body ml-3">
              <h6 class="mb-1"><a class="stretched-link text-900 font-weight-semi-bold" href="#!">iphone.jpg</a></h6>
              <div class="fs--1"><span class="font-weight-semi-bold">Antony</span><span class="font-weight-medium text-600 ml-2">Yesterday at 1:30 PM</span></div>
              <div class="hover-actions r-0 absolute-vertical-center"><a class="btn btn-light border-300 btn-sm mr-1 text-600 bg-white" data-toggle="tooltip" data-placement="top" title="Download" href="../assets/img/icons/cloud-download.svg" download="download"><img src="../assets/img/icons/cloud-download.svg" alt="" width="15" /></a>
                <button class="btn btn-light border-300 btn-sm mr-1 text-600 bg-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><img src="../assets/img/icons/edit-alt.svg" alt="" width="15" /></button>
              </div>
            </div>
          </div>
          <hr class="border-200" />
          <div class="media mb-3 hover-actions-trigger align-items-center">
            <div class="file-thumbnail"><img class="img-fluid" src="../assets/img/icons/zip.png" alt="" />
            </div>
            <div class="media-body ml-3">
              <h6 class="mb-1"><a class="stretched-link text-900 font-weight-semi-bold" href="#!">Falcon v1.8.2</a></h6>
              <div class="fs--1"><span class="font-weight-semi-bold">Jane</span><span class="font-weight-medium text-600 ml-2">27 Sep at 10:30 AM</span></div>
              <div class="hover-actions r-0 absolute-vertical-center"><a class="btn btn-light border-300 btn-sm mr-1 text-600 bg-white" data-toggle="tooltip" data-placement="top" title="Download" href="../assets/img/icons/cloud-download.svg" download="download"><img src="../assets/img/icons/cloud-download.svg" alt="" width="15" /></a>
                <button class="btn btn-light border-300 btn-sm mr-1 text-600 bg-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><img src="../assets/img/icons/edit-alt.svg" alt="" width="15" /></button>
              </div>
            </div>
          </div>
          <hr class="border-200" />
          <div class="media mb-3 hover-actions-trigger align-items-center">
            <div class="file-thumbnail"><img class="border h-100 w-100 fit-cover rounded-soft" src="../assets/img/products/2-thumb.png" alt="" />
            </div>
            <div class="media-body ml-3">
              <h6 class="mb-1"><a class="stretched-link text-900 font-weight-semi-bold" href="#!">iMac.jpg</a></h6>
              <div class="fs--1"><span class="font-weight-semi-bold">Rowen</span><span class="font-weight-medium text-600 ml-2">23 Sep at 6:10 PM</span></div>
              <div class="hover-actions r-0 absolute-vertical-center"><a class="btn btn-light border-300 btn-sm mr-1 text-600 bg-white" data-toggle="tooltip" data-placement="top" title="Download" href="../assets/img/icons/cloud-download.svg" download="download"><img src="../assets/img/icons/cloud-download.svg" alt="" width="15" /></a>
                <button class="btn btn-light border-300 btn-sm mr-1 text-600 bg-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><img src="../assets/img/icons/edit-alt.svg" alt="" width="15" /></button>
              </div>
            </div>
          </div>
          <hr class="border-200" />
          <div class="media mb-3 hover-actions-trigger align-items-center">
            <div class="file-thumbnail"><img class="img-fluid" src="../assets/img/icons/docs.png" alt="" />
            </div>
            <div class="media-body ml-3">
              <h6 class="mb-1"><a class="stretched-link text-900 font-weight-semi-bold" href="#!">functions.php</a></h6>
              <div class="fs--1"><span class="font-weight-semi-bold">John</span><span class="font-weight-medium text-600 ml-2">1 Oct at 4:30 PM</span></div>
              <div class="hover-actions r-0 absolute-vertical-center"><a class="btn btn-light border-300 btn-sm mr-1 text-600 bg-white" data-toggle="tooltip" data-placement="top" title="Download" href="../assets/img/icons/cloud-download.svg" download="download"><img src="../assets/img/icons/cloud-download.svg" alt="" width="15" /></a>
                <button class="btn btn-light border-300 btn-sm mr-1 text-600 bg-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><img src="../assets/img/icons/edit-alt.svg" alt="" width="15" /></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row no-gutters">
    <div class="col-sm-6 col-xxl-3 pr-sm-2 mb-3 mb-xxl-0">
      <div class="card">
        <div class="card-header d-flex flex-between-center bg-light py-2">
          <h6 class="mb-0">Active Users</h6>
          <div class="dropdown text-sans-serif btn-reveal-trigger">
            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none" type="button" id="dropdown-active-user" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
            <div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="dropdown-active-user">
              <div class="bg-white py-2"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body py-2">
          <div class="media align-items-center mb-3">
            <div class="avatar avatar-2xl status-online">
              <img class="rounded-circle" src="../assets/img/team/1-thumb.png" alt="" />

            </div>
            <div class="media-body ml-3">
              <h6 class="mb-0 font-weight-semi-bold"><a class="text-900" href="../pages/profile.html">Emma Watson</a></h6>
              <p class="text-500 fs--2 mb-0">Admin</p>
            </div>
          </div>
          <div class="media align-items-center mb-3">
            <div class="avatar avatar-2xl status-online">
              <img class="rounded-circle" src="../assets/img/team/2-thumb.png" alt="" />

            </div>
            <div class="media-body ml-3">
              <h6 class="mb-0 font-weight-semi-bold"><a class="text-900" href="../pages/profile.html">Antony Hopkins</a></h6>
              <p class="text-500 fs--2 mb-0">Moderator</p>
            </div>
          </div>
          <div class="media align-items-center mb-3">
            <div class="avatar avatar-2xl status-away">
              <img class="rounded-circle" src="../assets/img/team/3-thumb.png" alt="" />

            </div>
            <div class="media-body ml-3">
              <h6 class="mb-0 font-weight-semi-bold"><a class="text-900" href="../pages/profile.html">Anna Karinina</a></h6>
              <p class="text-500 fs--2 mb-0">Editor</p>
            </div>
          </div>
          <div class="media align-items-center mb-3">
            <div class="avatar avatar-2xl status-offline">
              <img class="rounded-circle" src="../assets/img/team/4-thumb.png" alt="" />

            </div>
            <div class="media-body ml-3">
              <h6 class="mb-0 font-weight-semi-bold"><a class="text-900" href="../pages/profile.html">John Lee</a></h6>
              <p class="text-500 fs--2 mb-0">Admin</p>
            </div>
          </div>
          <div class="media align-items-center mb-3">
            <div class="avatar avatar-2xl status-offline">
              <img class="rounded-circle" src="../assets/img/team/5-thumb.png" alt="" />

            </div>
            <div class="media-body ml-3">
              <h6 class="mb-0 font-weight-semi-bold"><a class="text-900" href="../pages/profile.html">Rowen Atkinson</a></h6>
              <p class="text-500 fs--2 mb-0">Editor</p>
            </div>
          </div>
        </div>
        <div class="card-footer bg-light p-0"><a class="btn btn-sm btn-link btn-block py-2" href="../pages/people.html">All active users<span class="fas fa-chevron-right ml-1 fs--2"></span></a></div>
      </div>
    </div>
    <div class="col-sm-6 col-xxl-3 pl-sm-2 order-xxl-1 mb-3 mb-xxl-0">
      <div class="card h-100">
        <div class="card-header bg-light d-flex flex-between-center py-2">
          <h6 class="mb-0">Bandwidth Saved</h6>
          <div class="dropdown text-sans-serif btn-reveal-trigger">
            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none" type="button" id="dropdown-bandwidth-saved" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
            <div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="dropdown-bandwidth-saved">
              <div class="bg-white py-2"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body d-flex flex-center">
          <div>
            <div class="progress-circle progress-circle-dashboard" data-options='{"color":"url(#gradient)","progress":93,"strokeWidth":5,"trailWidth":5}'></div>
            <div class="text-center mt-4">
              <h6 class="fs-0 mb-1"><span class="fas fa-check text-success mr-1" data-fa-transform="shrink-2"></span>35.75 GB saved</h6>
              <p class="fs--1 mb-0">38.44 GB total bandwidth</p>
            </div>
          </div>
        </div>
        <div class="card-footer bg-light py-2">
          <div class="row flex-between-center">
            <div class="col-auto">
              <select class="custom-select custom-select-sm">
                <option>Last 6 Months</option>
                <option>Last Year</option>
                <option>Last 2 Year</option>
              </select>
            </div>
            <div class="col-auto"><a class="fs--1" href="#!">Help</a></div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xxl-6 px-xxl-2">
      <div class="card h-100">
        <div class="card-header bg-light py-2">
          <div class="row flex-between-center">
            <div class="col-auto">
              <h6 class="mb-0">Top Products</h6>
            </div>
            <div class="col-auto d-flex"><a class="btn btn-link btn-sm mr-2" href="#!">View Details</a>
              <div class="dropdown text-sans-serif btn-reveal-trigger">
                <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none" type="button" id="dropdown-running-projects" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
                <div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="dropdown-running-projects">
                  <div class="bg-white py-2"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body h-100">
          <div class="echart-bar-top-products h-100" data-echart-responsive="true"></div>
        </div>
      </div>
    </div>
  </div>
@endsection
