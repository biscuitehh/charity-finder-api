<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('charity', function(Blueprint $table)
		{
            // ID
			$table->increments('id');
			$table->unique('id');

            // Federal EIN
            $table->string('ein')->nullable();
            $table->index('ein');

            // Name
			$table->string('name')->nullable();
            $table->index('name');

            // ICO
            $table->string('ico')->nullable();

            // Address
            $table->string('street_address')->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('zip')->nullable();

            // Other information
			$table->string('group')->nullable();
			$table->string('subsection')->nullable();
			$table->string('affiliation')->nullable();
			$table->string('classification')->nullable();
			$table->string('ruling')->nullable();
			$table->string('deductibility')->nullable();
			$table->string('foundation')->nullable();
			$table->string('activity')->nullable();
			$table->string('organization')->nullable();
			$table->string('status')->nullable();
			$table->string('tax_period')->nullable();
			$table->string('asset_cd')->nullable();
			$table->string('income_cd')->nullable();
			$table->string('filing_req_cd')->nullable();
			$table->string('pf_filing_req_cd')->nullable();
			$table->string('acct_pd')->nullable();
			$table->string('asset_amt')->nullable();
			$table->string('income_amt')->nullable();
			$table->string('revenue_amt')->nullable();
			$table->string('ntee_cd')->nullable();
			$table->string('sort_name')->nullable();

            // Timestamps
			$table->timestamps();
		});

        // Location
        DB::statement("ALTER TABLE charity ADD COLUMN location GEOMETRY(POINT, 4326)");

        // Index
        DB::statement("CREATE INDEX charity_location_index ON charity USING GIST (location)");
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('charity');
	}

}
