<?php

namespace App\Console\Commands;

use App\Models\Poll\ParticipantWord;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CleanWords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'etl:clean-words';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean all participant words';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->cleanDashes();
        $this->cleanSemiColon();
        $this->cleanDots();
    }

    public function cleanDashes()
    {
        try {
            $this->info('Cleaning dashes');
            DB::beginTransaction();
            $regs = ParticipantWord::where('word', 'like', '%-%')->get()->toArray();

            $newWords = [];
            $toDelete = [];
            foreach ($regs as $reg) {
                $parts = explode('-', $reg['word']);
                foreach ($parts as $newWord) {
                    $newWord = preg_replace("/[^a-zA-Z ]/", "", trim($newWord));
                    if (!$newWord) continue;

                    $newReg = array_merge((array)$reg, ['word' => $newWord, 'created_at' => Carbon::parse($reg['created_at']), 'updated_at' => now()]);
                    unset($newReg['id']);
                    $newWords[] = $newReg;
                }
                $toDelete[] = $reg['id'];
            }

            ParticipantWord::whereIn('id', $toDelete)->delete();
            ParticipantWord::insert($newWords);

            DB::commit();

            return $newWords;
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->error($th->getMessage());
        }
    }
    public function cleanSemiColon()
    {
        try {
            $this->info('Cleaning semicolons');
            DB::beginTransaction();
            $regs = ParticipantWord::where('word', 'like', '%;%')->get()->toArray();

            $newWords = [];
            $toDelete = [];
            foreach ($regs as $reg) {
                $parts = explode(';', $reg['word']);
                foreach ($parts as $newWord) {
                    $newWord = preg_replace("/[^a-zA-Z ]/", "", trim($newWord));
                    if (!$newWord) continue;

                    $newReg = array_merge((array)$reg, ['word' => $newWord, 'created_at' => Carbon::parse($reg['created_at']), 'updated_at' => now()]);
                    unset($newReg['id']);
                    $newWords[] = $newReg;
                }
                $toDelete[] = $reg['id'];
            }

            ParticipantWord::whereIn('id', $toDelete)->delete();
            ParticipantWord::insert($newWords);

            DB::commit();

            return $newWords;
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->error($th->getMessage());
        }
    }

    public function cleanDots()
    {
        try {
            $this->info('Cleaning dots');
            $regs = ParticipantWord::where('word', 'like', '%.%')->chunk(20, function ($chunk) {
                foreach ($chunk as $reg) {
                    $reg->word = preg_replace("/[^a-zA-Z ]/", "", $reg->word);
                    $reg->updated_at = now();
                    $result = $reg->save();
                }
            });
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }
    }
}
