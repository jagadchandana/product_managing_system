import React from 'react'
import { Head, useForm, usePage, Link } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'

const Edit: React.FC = () => {
  const { product } = usePage().props as any
  const form = useForm({
    name: product.name || '',
    price: product.price || '0.00',
    description: product.description || '',
    stock_quantity: product.stock_quantity || 0,
  })

  function submit(e: React.FormEvent) {
    e.preventDefault()
    form.put(route('products.update', product.id))
  }

  return (
    <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Edit Product</h2>}>
      <Head title={`Edit Product #${product.id}`} />

      <div className="py-6">
        <div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
          <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900">
              <form onSubmit={submit} className="space-y-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700">Name</label>
                  <input className="mt-1 block w-full rounded border-gray-300 px-3 py-2" type="text" value={form.data.name} onChange={e => form.setData('name', e.target.value)} required />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Price</label>
                  <input className="mt-1 block w-full rounded border-gray-300 px-3 py-2" type="number" step="0.01" value={form.data.price as any} onChange={e => form.setData('price', e.target.value)} required />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Description</label>
                  <textarea className="mt-1 block w-full rounded border-gray-300 px-3 py-2" value={form.data.description} onChange={e => form.setData('description', e.target.value)} />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Stock Quantity</label>
                  <input className="mt-1 block w-full rounded border-gray-300 px-3 py-2" type="number" value={form.data.stock_quantity as any} onChange={e => form.setData('stock_quantity', parseInt(e.target.value || '0'))} required />
                </div>
                <div className="flex flex-col sm:flex-row gap-2">
                  <button type="submit" disabled={form.processing} className="rounded bg-indigo-600 px-3 py-2 text-white">Update</button>
                  <Link href={route('products.index')} className="rounded bg-gray-200 px-3 py-2 text-center">Cancel</Link>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  )
}

export default Edit
