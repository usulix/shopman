import { usePage } from '@inertiajs/react';
import { PaginatedData } from '@/types';
import MainLayout from '@/Layouts/MainLayout';


const Index = () => {

  const { tasks } = usePage<{
    tasks: PaginatedData<Task>;
  }>().props;

  return (
    <div>
      <h1 className="mb-8 text-3xl font-bold">Tasks</h1>
      <p>Here is where we create repair orders.</p>
    </div>
  )
}

/**
 * Persistent Layout (Inertia.js)
 *
 * [Learn more](https://inertiajs.com/pages#persistent-layouts)
 */
Index.layout = (page: React.ReactNode) => (
  <MainLayout title="Tasks" children={page} />
);

export default Index;
