<?php

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

function mort_calc_shortcode( $atts ) {
	$a = shortcode_atts( array(
		'foo' => 'something',
		'bar' => 'something else',
  ), $atts );
  
  ob_start();
  ?>
  
  <div class="mc-container">
    <div class="mc-header">
      <div class="mc-header-title">Investment Property Calculator</div>
      <div class="mc-header-subtitle">Edit the fields in the Investment Property Calculator below to change economic assumptions (ex. increase vacancy, maintenance, etc.) and see the resulting returns.</div>
    </div>

    <div class="mc-col mc-col-left">
      <div class="mc-groups">
        <div class="mc-group">
          <div class="mc-group-header">
            <div class="mc-label">ACQUISITION AND DEBT SERVICE SUMMARY</div>
            
            <div class="mc-tooltip">
              <div class="mc-tooltip-icon">?</div>
              <div class="mc-tooltip-definition">Enter Purchase Price of the property. If you are financing the property, enter the Down Payment percentage here. For most investors, it’s usually a number between 20-30%. For a cash purchase, enter 100%. Next, enter the Closing Costs & Fees. If you are working with a lender, she can give you a good faith estimate for this line item.</div>
            </div>
          </div>
          
          <div class="mc-group-variables">
            <div class="mc-group-variable mc-input">
              <div class="mc-variable-label">Property Purchase Price</div>
              <input class="mc-variable-value" type="text">
            </div>
            <div class="mc-group-variable mc-slider">
              <div class="mc-variable-label">Down Payment %</div>
              <input class="mc-variable-value" id="slider1" type="range" min="0" max="100" onchange="slider1Output.value=value">
              <div class="mc-slider-output"><output id="slider1Output">50</output>%</div>
            </div>
            <div class="mc-group-variable mc-slider">
              <div class="mc-variable-label">Mortgage Interest Rate (30 Yr Fixed)</div>              
              <input class="mc-variable-value" id="slider2" type="range" min="0" max="100" onchange="slider2Output.value=value">
              <div class="mc-slider-output"><output id="slider2Output">50</output>%</div>
            </div>
            <div class="mc-group-variable mc-input">
              <div class="mc-variable-label">Closing Costs & Fees</div>
              <input class="mc-variable-value" type="text">
            </div>
          </div>
        </div>

        <div class="mc-group">
          <div class="mc-group-header">
            <div class="mc-label">PROPERTY INCOME AND OPERATING EXPENSE DATA</div>
            
            <div class="mc-tooltip">
              <div class="mc-tooltip-icon">?</div>
              <div class="mc-tooltip-definition">Enter the Monthly Rent, Annual Property Tax and Annual Insurance Premium amounts here. The tax information is available on most county property tax websites. The insurance information is available from the insurance company. Additionally, it is important to research whether or not the property is located in a homeowner’s association that carries Homeowner’s Association (HOA) fees. If so, enter the annual amount.</div>
            </div>
          </div>
          
          <div class="mc-group-variables">
            <div class="mc-group-variable mc-input">
              <div class="mc-variable-label">Monthly Rent</div>
              <input class="mc-variable-value" type="text">
            </div>
            <div class="mc-group-variable mc-input">
              <div class="mc-variable-label">Annual Property Tax</div>
              <input class="mc-variable-value" type="text">
            </div>
            <div class="mc-group-variable mc-input">
              <div class="mc-variable-label">Annual Insurance Premium</div>
              <input class="mc-variable-value" type="text">
            </div>
            <div class="mc-group-variable mc-input">
              <div class="mc-variable-label">Annual HOA Fees / Other</div>
              <input class="mc-variable-value" type="text">
            </div>
          </div>
        </div>

        <div class="mc-group">
          <div class="mc-group-header">
            <div class="mc-label">ECONOMIC MODELING ASSUMPTIONS (Per Year, for 5 Years)</div>
            
            <div class="mc-tooltip">
              <div class="mc-tooltip-icon">?</div>
              <div class="mc-tooltip-definition">In this section, you need to make some assumptions about the property as indicated to the right. Vacancy Rate: Percentage of Gross Scheduled Income (GSI) or total annual rents possible per year. Maintenance Rate: Percentage of Gross Operating Income (GOI), or the income the property receives after accounting for vacancy. Property Management Rate: Percentage of GOI, the amount of rents actually collected by the property manager. Property Appreciation Rate: Your expectation of how the property value will appreciate. Expense Inflation Rate: The general economic inflation percentage rate. Sales Costs: Costs associated with selling property when it is finally sold, including sales commissions and closing costs. This is a one-time expense.</div>
            </div>
          </div>
          
          <div class="mc-group-variables">
            <div class="mc-group-variable mc-input">
              <div class="mc-variable-label">Vacancy Rate (% of GSI)</div>
              <input class="mc-variable-value" type="text">
              <a href="#">Advanced +</a>
            </div>
            <div class="mc-group-variable mc-input">
              <div class="mc-variable-label">Maintenance Rate (% of GOI)</div>
              <input class="mc-variable-value" type="text">
              <a href="#">Advanced +</a>
            </div>
            <div class="mc-group-variable mc-input">
              <div class="mc-variable-label">Property Mgmt Rate (% of GOI)</div>
              <input class="mc-variable-value" type="text">
            </div>
            <div class="mc-group-variable mc-input">
              <div class="mc-variable-label">Property Appreciation Rate</div>
              <input class="mc-variable-value" type="text">
            </div>
            <div class="mc-group-variable mc-input">
              <div class="mc-variable-label">Rent Appreciation Rate</div>
              <input class="mc-variable-value" type="text">
            </div>
            <div class="mc-group-variable mc-input">
              <div class="mc-variable-label">Expense Inflation Rate</div>
              <input class="mc-variable-value" type="text">
            </div>
            <div class="mc-group-variable mc-input">
              <div class="mc-variable-label">Sale Cost Rate (% of Price)</div>
              <input class="mc-variable-value" type="text">
            </div>
          </div>
        </div>
      </div>
      
      <div class="mc-reset-container">
        <button class="mc-btn mc-reset">RESET SAMPLE DATA</button>
      </div>
    </div>

    <div class="mc-col mc-col-right">
      <div class="mc-groups">
        <div class="mc-group">
          <div class="mc-group-header">
            <div class="mc-label">INVESTMENT AND DEBT SERVICE CALCULATIONS</div>
            
            <div class="mc-tooltip">
              <div class="mc-tooltip-icon">?</div>
              <div class="mc-tooltip-definition">Enter Purchase Price of the property. If you are financing the property, enter the Down Payment percentage here. For most investors, it’s usually a number between 20-30%. For a cash purchase, enter 100%. Next, enter the Closing Costs & Fees. If you are working with a lender, she can give you a good faith estimate for this line item.</div>
            </div>
          </div>
          
          <div class="mc-group-variables">
            <div class="mc-group-variable mc-text">
              <div class="mc-variable-label">Down Payment</div>
              <div class="mc-variable-value">$20,000</div>
            </div>
            <div class="mc-group-variable mc-text">
              <div class="mc-variable-label">Closing Costs & Fees</div>
              <div class="mc-variable-value">$4,000</div>
            </div>
            <div class="mc-group-variable mc-text mc-total">
              <div class="mc-variable-label">Total Cash Investment</div>
              <div class="mc-variable-value">$24,000</div>
            </div>

            <div class="mc-group-variable mc-text">
              <div class="mc-variable-label">DEBT SERVICE SUMMARY</div>
            </div>
            <div class="mc-group-variable mc-text">
              <div class="mc-variable-label">Amount Financed (80.000%)</div>
              <div class="mc-variable-value">$180,000</div>
            </div>
            <div class="mc-group-variable mc-text">
              <div class="mc-variable-label">Debt Service (P&I), Monthly</div>
              <div class="mc-variable-value">($500)</div>
            </div>  
            <div class="mc-group-variable mc-text mc-total">
              <div class="mc-variable-label">Debt Service (P&I), Annual</div>
              <div class="mc-variable-value">$6,000</div>
            </div>
          </div>
        </div>

        <div class="mc-group">
          <div class="mc-group-header">
            <div class="mc-label">KEY FINANCIAL RATIOS (RETURN ON INVESTMENT)</div>
            
            <div class="mc-tooltip">
              <div class="mc-tooltip-icon">?</div>
              <div class="mc-tooltip-definition">Enter Purchase Price of the property. If you are financing the property, enter the Down Payment percentage here. For most investors, it’s usually a number between 20-30%. For a cash purchase, enter 100%. Next, enter the Closing Costs & Fees. If you are working with a lender, she can give you a good faith estimate for this line item.</div>
            </div>
          </div>
          
          <div class="mc-group-variables">
            <div class="mc-group-variable mc-text">
                <div class="mc-variable-label-container">  
                  <div class="mc-variable-label">10-Year Average Cash-On-Cash ROI</div>
                  <div class="mc-variable-sublabel">Avg 10-year CoC</div>
                </div>  
                <div class="mc-variable-value">10%</div>
            </div>
            <div class="mc-group-variable mc-text">
                <div class="mc-variable-label-container">  
                  <div class="mc-variable-label">Cash-On-Cash ROI + Debt Paydown ROI</div>
                  <div class="mc-variable-sublabel">avg 10-Year CoC + Debt Paydown ROI, Excl. Appreciation</div>
                </div>  
                <div class="mc-variable-value">10%</div>
            </div>
            <div class="mc-group-variable mc-text">
                <div class="mc-variable-label-container">  
                  <div class="mc-variable-label">10-Year Average Capitalization Rate</div>
                  <div class="mc-variable-sublabel">10-Year Avg Net Operating Income ÷ Purchase price</div>
                </div>  
                <div class="mc-variable-value">10%</div>
            </div>
            <div class="mc-group-variable mc-text">
                <div class="mc-variable-label-container">  
                  <div class="mc-variable-label">10-Year Internal Rate of Return</div>
                  <div class="mc-variable-sublabel">IRR per Year</div>
                </div>  
                <div class="mc-variable-value">10%</div>
            </div>
          </div>
        </div>
      </div>

      <div class="mc-contact">
        <div>Want a copy of the results?</div>
        <input type="email" placeholder="Enter email address">
        <button class="mc-btn mc-submit">SEND RESULTS</button>
      </div>
    </div>
  </div>

  <?php
	return ob_get_clean();
}
add_shortcode( 'mortgage-calculator', 'mort_calc_shortcode' );