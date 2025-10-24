<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Future Pay Coin</title>
      <?php include "./common/header.php" ?>
   </head>
   <body>
      <?php include "./common/navbar.php"?>
      <div class="common-banner">
         <div class="overlay"></div>
         <div class="container">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Market Update</li>
               </ol>
            </nav>
         </div>
      </div>
      <section class="live-chart-section">
         <div class="container">
            <div class="live-chart-content">
               <div class="headline">
                  <h3>
                     Crypto Currency <span>Live Chart</span>
                  </h3>
                  <p>
                     we deal with any currency
                  </p>
               </div>
               <div class="chart-table">
                  <div class="row">
                     <div class="col-lg-8">
                        <ul class="crypto-menubar">
                           <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              All Date
                              </a>
                              <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="#">Today</a></li>
                                 <li><a class="dropdown-item" href="#">Yesterday</a></li>
                                 <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                                 <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                                 <li><a class="dropdown-item" href="#">This Month</a></li>
                                 <li><a class="dropdown-item" href="#">Last Month</a></li>
                                 <li><a class="dropdown-item" href="#">Custom Range</a></li>
                              </ul>
                           </li>
                           <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Coin
                              </a>
                              <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="#">Bitcoin (BTC)</a></li>
                                 <li><a class="dropdown-item" href="#">Ethereum (ETH)</a></li>
                                 <li><a class="dropdown-item" href="#">Ripple (XRP)</a></li>
                                 <li><a class="dropdown-item" href="#">Litecoin (LTC)</a></li>
                                 <li><a class="dropdown-item" href="#">Cardano (ADA)</a></li>
                              </ul>
                           </li>
                           <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Token
                              </a>
                              <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="#">USDT</a></li>
                                 <li><a class="dropdown-item" href="#">BNB</a></li>
                                 <li><a class="dropdown-item" href="#">SOL</a></li>
                                 <li><a class="dropdown-item" href="#">DOGE</a></li>
                              </ul>
                           </li>
                           <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              USD
                              </a>
                              <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="#">USD</a></li>
                                 <li><a class="dropdown-item" href="#">EUR</a></li>
                                 <li><a class="dropdown-item" href="#">GBP</a></li>
                                 <li><a class="dropdown-item" href="#">JPY</a></li>
                                 <li><a class="dropdown-item" href="#">AUD</a></li>
                              </ul>
                           </li>
                           <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Tools
                              </a>
                              <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="#">Portfolio Tracker</a></li>
                                 <li><a class="dropdown-item" href="#">Trading Calculator</a></li>
                                 <li><a class="dropdown-item" href="#">Price Alerts</a></li>
                                 <li><a class="dropdown-item" href="#">Crypto News</a></li>
                                 <li><a class="dropdown-item" href="#">Charts & Analytics</a></li>
                              </ul>
                           </li>
                        </ul>
                     </div>
                     <div class="col-lg-4">
                        <form class="d-flex" role="search">
                           <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
                           <button class="btn btn-outline-success" type="submit">Search</button>
                        </form>
                     </div>
                  </div>
                  <div class="table-responsive">
                     <table class="table crypto-table table-striped table-bordered">
                        <thead>
                           <tr class="list-name">
                              <th scope="col">#</th>
                              <th scope="col">Name</th>
                              <th scope="col">
                                 <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                 Market Cap
                                 </a>
                                 <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Top Gainers</a></li>
                                    <li><a class="dropdown-item" href="#">Top Losers</a></li>
                                    <li><a class="dropdown-item" href="#">Highest Volume</a></li>
                                 </ul>
                              </th>
                              <th scope="col">Price</th>
                              <th scope="col">Calculating Value</th>
                              <th scope="col">Volume</th>
                              <th scope="col">% 1h</th>
                              <th scope="col">% 24h</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr class="bit-list">
                              <th scope="row">1</th>
                              <td><img src="assets//images/bitcoin-logo.png" alt="bitcoin"> Bitcoin</td>
                              <td>₹69,765,758,7768</td>
                              <td>₹45,765</td>
                              <td>₹45,765,450</td>
                              <td>₹45,765,5090</td>
                              <td class="profit"><span>
                                 +16.04%
                                 </span>
                              </td>
                              <td class="profit"><span>
                                 +08.60%
                                 </span>
                              </td>
                           </tr>
                           <tr class="bit-list">
                              <th scope="row">2</th>
                              <td><img src="assets//images/ethereum.png" alt="ethereum"> Ethereum</td>
                              <td>₹59,234,123,7768</td>
                              <td>₹35,465</td>
                              <td>₹42,765,450</td>
                              <td>₹40,765,5090</td>
                              <td class="loss"><span>
                                 -02.04%
                                 </span>
                              </td>
                              <td class="loss"><span>
                                 -01.60%
                                 </span>
                              </td>
                           </tr>
                           <tr class="bit-list">
                              <th scope="row">3</th>
                              <td><img src="assets//images/ripple.png" alt="ripple"> Ripple</td>
                              <td>₹69,765,758,7768</td>
                              <td>₹45,765</td>
                              <td>₹45,765,450</td>
                              <td>₹45,765,5090</td>
                              <td class="profit"><span>
                                 +16.04%
                                 </span>
                              </td>
                              <td class="profit"><span>
                                 +08.60%
                                 </span>
                              </td>
                           </tr>
                           <tr class="bit-list">
                              <th scope="row">4</th>
                              <td><img src="assets//images/litecoin.png" alt="Litecoin"> Litecoin</td>
                              <td>₹69,765,758,7768</td>
                              <td>₹45,765</td>
                              <td>₹45,765,450</td>
                              <td>₹45,765,5090</td>
                              <td class="profit"><span>
                                 +16.04%
                                 </span>
                              </td>
                              <td class="profit"><span>
                                 +08.60%
                                 </span>
                              </td>
                           </tr>
                           <tr class="bit-list">
                              <th scope="row">5</th>
                              <td><img src="assets//images/gnosis.png" alt="Gnosis"> Gnosis</td>
                              <td>₹69,765,758,7768</td>
                              <td>₹45,765</td>
                              <td>₹45,765,450</td>
                              <td>₹45,765,5090</td>
                              <td class="profit"><span>
                                 +16.04%
                                 </span>
                              </td>
                              <td class="profit"><span>
                                 +08.60%
                                 </span>
                              </td>
                           </tr>
                           <tr class="bit-list">
                              <th scope="row">6</th>
                              <td><img src="assets//images/stratis.png" alt="Stratis"> Stratis</td>
                              <td>₹69,765,758,7768</td>
                              <td>₹45,765</td>
                              <td>₹45,765,450</td>
                              <td>₹45,765,5090</td>
                              <td class="profit"><span>
                                 +16.04%
                                 </span>
                              </td>
                              <td class="profit"><span>
                                 +08.60%
                                 </span>
                              </td>
                           </tr>
                           <tr class="bit-list">
                              <th scope="row">7</th>
                              <td><img src="assets//images/monero.png" alt="Monero"> Monero</td>
                              <td>₹59,234,123,7768</td>
                              <td>₹35,465</td>
                              <td>₹42,765,450</td>
                              <td>₹40,765,5090</td>
                              <td class="loss"><span>
                                 -02.04%
                                 </span>
                              </td>
                              <td class="loss"><span>
                                 -01.60%
                                 </span>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <?php include "./common/footer.php"?>
      <?php include "./common/vendor.php" ?>
   </body>
</html>