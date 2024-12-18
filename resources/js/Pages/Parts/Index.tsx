import { usePage } from '@inertiajs/react';
import { PaginatedData } from '@/types';
import MainLayout from '@/Layouts/MainLayout';


const Index = () => {

  const { parts } = usePage<{
    parts: PaginatedData<Part>;
  }>().props;

  return (
    <div>
      <h1 className="mb-8 text-3xl font-bold">Parts</h1>
      <p>Step up to the parts counter.</p>
    </div>
  )
}

/**
 * Persistent Layout (Inertia.js)
 *
 * [Learn more](https://inertiajs.com/pages#persistent-layouts)
 */
Index.layout = (page: React.ReactNode) => (
  <MainLayout title="Parts" children={page} />
);

export default Index;
