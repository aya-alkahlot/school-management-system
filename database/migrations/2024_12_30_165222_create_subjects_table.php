
    public function index()
    {
        $exams = Exam::get();
        return view('pages.Exams.index', compact('exams'));
    }

    public function create()
    {
        return view('pages.Exams.create');
    }

    public function store($request)
    {
        try {

            $exams = new Exam();
            $exams->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $exams->term = $request->term;
            $exams->academic_year = $request->academic_year;
            $exams->save();
            toastr()->success(trans('messages.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update($request)
    {
        // TODO: Implement update() method.
    }

    public function destroy($request)
    {
        // TODO: Implement destroy() method.
    }
}
