import React from 'react'
import { Head, Link, usePage } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'

const Show: React.FC = () => {
  const { product } = usePage().props as any
  return (
    <AuthenticatedLayout header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Product #{product.id}</h2>}>
      <Head title={`Product #${product.id}`} />

      <div className="py-6">
        <div className="mx-auto max-w-3xl sm:px-6 lg:px-8">
          <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900">
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <p className="text-sm text-gray-500">Name</p>
                  <div className="text-lg font-medium">{product.name}</div>
                </div>
                <div>
                  <p className="text-sm text-gray-500">Price</p>
                  <div className="text-lg font-medium">{Number(product.price).toFixed(2)}</div>
                </div>
                <div>
                  <p className="text-sm text-gray-500">Stock Quantity</p>
                  <div className="text-lg font-medium">{product.stock_quantity}</div>
                </div>
                <div>
                  <p className="text-sm text-gray-500">&nbsp;</p>
                  <div>&nbsp;</div>
                </div>
              </div>

              <div className="mt-4">
                <p className="text-sm text-gray-500">Description</p>
                <div className="whitespace-pre-wrap mt-1 text-gray-700">{product.description}</div>
              </div>

              <div className="mt-6 flex gap-2">
                <Link href={route('products.edit', product.id)} className="rounded bg-indigo-600 px-3 py-2 text-white">Edit</Link>
                <Link href={route('products.index')} className="rounded bg-gray-200 px-3 py-2 text-gray-700">Back</Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  )
}

export default Show
